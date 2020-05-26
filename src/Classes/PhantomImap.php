<?php
/**
 * Created by PhpStorm.
 * User: rehash
 * Date: 17.09.18 г.
 * Time: 6:04
 */

namespace dvplex\Phantom\Classes;


class PhantomImap {

	public $server = '';
	public $user = '';
	public $pass = '';
	public $totalMsg = '';
	protected $conn = '';
	protected $header = '';
	public $folder = 'INBOX';

	function __construct() {
	}

	public function connect() {
		$this->conn = imap_open("{{$this->server}/imap/ssl/novalidate-cert}{$this->folder}", $this->user, $this->pass);
		$this->totalMsg = imap_num_msg($this->conn);

		return;
	}


	public function listFolders() {
		$server = "{{$this->server}/imap/ssl/novalidate-cert}";
		$r = imap_list($this->conn, $server, "*");
		for ($i = 0; $i < count($r); $i++)
			$r[$i] = str_replace($server, '', $r[$i]);

		return $r;
	}

	public function flagMessages($from = false, $to = false, $flag = false, $is_UID = false) {
		if ($is_UID == true)
			$opt = ST_UID;
		for ($i = $from; $i < $to + 1; $i++) {
			echo "Marking message #{$i} as {$flag}\n";
			switch ($flag) {
				case 'unread':
					@imap_clearflag_full($this->conn, $i, "\\Seen", $opt);
					break;
				case 'read':
					@imap_setflag_full($this->conn, $i, "\\Seen", $opt);
					break;
				case 'delete':
					@imap_delete($this->conn, $i, $opt);
					break;
				default:
				case 'unread':
			}
		}
		imap_expunge($this->conn);
	}

	public function getMessages() {
		$r = imap_search($this->conn, 'UNSEEN');
		$msg = [];
		$n = 0;
		if ($r)
			foreach ($r as $k => $v) {
				$this->header = @imap_headerinfo($this->conn, $v);
				$msg[$n] = $this->buildMessage($v);
				$msg[$n]['message_id'] = $this->header->message_id;
				$msg[$n]['msgno'] = $v;
				if (isset($this->header->in_reply_to))
					$msg[$n]['in_reply_to'] = trim($this->header->in_reply_to);
				if (isset($this->header->references))
					$msg[$n]['references'] = trim($this->header->references);
				$n++;
			}
		imap_close($this->conn);

		return $msg;
	}

	protected function buildMessage($uid) {
		echo "Building message #{$uid}\n";
		$msg = [];
		$msg['id'] = imap_uid($this->conn, $uid);
		$msg['from'] = @imap_utf8($this->header->fromaddress);
		$msg['subject'] = (isset($this->header->subject)) ? mb_decode_mimeheader($this->header->subject) : '';
		$msg['date'] = strtotime($this->header->MailDate);
		$msg['header'] = imap_fetchheader($this->conn, $uid, FT_PREFETCHTEXT);
		$msg['message']['RAW'] = imap_body($this->conn, $uid);
		$structure = imap_fetchstructure($this->conn, $uid);
		$he = @imap_headerinfo($this->conn, $uid);
		//print_r($he);
		//exit;
		if (isset($structure->parts)) {
			$flattenedParts = $this->flattenParts($structure->parts);
			foreach ($flattenedParts as $partNumber => $part) {
				switch ($part->type) {
					case 0:
						@$msg['message'][$part->subtype] .= $this->getPart($uid, $partNumber, $part->encoding);
						if ($part->subtype == 'HTML') {
							$message = $this->getPart($uid, $partNumber, $part->encoding);
							$msg['message'][$part->subtype] = $this->stripHtmlBody($message);
						}
					case 1:
						// multi-part headers, can ignore

						break;
					case 2:
						// attached message headers, can ignore
						break;

					case 3: // application
					case 4: // audio
					case 5: // image
					case 6: // video
					case 7: // other
						$filename = $this->getFilenameFromPart($part);
						if ($filename) {
							$attachment = $this->getPart($uid, $partNumber, $part->encoding);
							$imageid = '';
							if (isset($part->id)) {
								$id = $part->id;
								$imageid = substr($id, 1, -1);
								$imageid = "cid:" . $imageid;
							}
							$msg['attachment'][$filename]['filename'] = $filename;
							$msg['attachment'][$filename]['type'] = (isset($part->disposition)) ? $part->disposition : '';
							$msg['attachment'][$filename]['imageId'] = $imageid;
							$msg['attachment'][$filename]['size'] = $part->bytes;
							$msg['attachment'][$filename]['file'] = $attachment;

							// now do something with the attachment, e.g. save it somewhere
						}
						else {
							// don't know what it is
						}
						break;

				}
			}
		}
		else {
			$text = $this->getPart($uid, '1.2', $structure->encoding);
			if (!$text) {
				$text = $this->getPart($uid, '1', $structure->encoding);
				$msg['message']['PLAIN'] = $text;
				if ($structure->subtype == 'HTML')
					$msg['message']['HTML'] = $text;
			}
		}
		if (isset($msg['message']['HTML']) && $msg['message']['HTML'])
			$msg['messageHtmlLength'] = mb_strlen($msg['message']['HTML'], '8bit');
		if (isset($msg['message']['PLAIN']) && $msg['message']['PLAIN'])
			$msg['messagePlainLength'] = mb_strlen($msg['message']['PLAIN'], '8bit');

		return $msg;
	}

	protected function flattenParts($messageParts, $flattenedParts = [], $prefix = '', $index = 1, $fullPrefix = true) {

		foreach ($messageParts as $part) {
			$flattenedParts[$prefix . $index] = $part;
			if (isset($part->parts)) {
				if ($part->type == 2) {
					$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.', 0, false);
				}
				elseif ($fullPrefix) {
					$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix . $index . '.');
				}
				else {
					$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
				}
				unset($flattenedParts[$prefix . $index]->parts);
			}
			$index++;
		}

		return $flattenedParts;

	}

	protected function getPart($messageNumber, $partNumber, $encoding) {
		$str = imap_fetchmime($this->conn, $messageNumber, $partNumber);
		$data = imap_fetchbody($this->conn, $messageNumber, $partNumber);
		switch ($encoding) {
			case 0:
				return $data; // 7BIT
			case 1:
				return $data; // 8BIT
			case 2:
				return $data; // BINARY
			case 3:
				return base64_decode($data); // BASE64
			case 4:
				$data = quoted_printable_decode($data);
				$str = strtoupper(get_string_between($str, 'charset="', '"'));
				if ($str)
					$data = iconv($str, 'UTF-8', $data);

				return $data; // QUOTED_PRINTABLE
			case 5:
				return $data; // OTHER
		}


	}

	protected function stripHtmlBody($message) {

		$style = '';
		if (preg_match_all('/<style[^>]*>(.*?)<\/style>/si', $message, $m))
			$style = $m[0][0];
		$body1 = preg_replace('/<html[^>]*>(.*?)<body[^>]*>|<\/body><\/html>/si', '', $message);
		if ($body1)
			$message = $style . $body1;

		return $message;
	}

	protected function getFilenameFromPart($part) {

		$filename = '';

		if ($part->ifdparameters) {
			foreach ($part->dparameters as $object) {
				if (strtolower($object->attribute) == 'filename') {
					$filename = $object->value;
				}
			}
		}

		if (!$filename && $part->ifparameters) {
			foreach ($part->parameters as $object) {
				if (strtolower($object->attribute) == 'name') {
					$filename = $object->value;
				}
			}
		}

		return $filename;

	}

	function saveToSent($msg) {
		imap_append($this->conn, "{{$this->server}/imap/ssl/novalidate-cert}{$this->folder}", $msg);

		return;
	}

	function __destruct() {
		if (is_resource($this->conn))
			imap_close($this->conn);
	}
}