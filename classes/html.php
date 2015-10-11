<?php
class html {
	public function DrawChatBox($input="") {
		$c  = "<form method='post' action='index.php'>\n";
		$c .= "Question: <input type='text' name='message'><input type='submit' value='Send' size=10>\n";
		$c .= "</form>\n";
		return $c;
	}
	public function DrawResponse($input="") {
		$c = $input;
		return $c;
	}
	public function ShowUnknownInputs() {
		$db = $GLOBALS['database'];
		$c = "";
		$sql = "SELECT id, input
						FROM unknown_inputs
						WHERE input <> ''
						LIMIT 10
						";
		$result = $db->Query($sql);
		if ($db->NumRows($result) == 0) {
			$this->Errors("No inputs");
			return false;
		}
		else {
			$c .= "<table border=1>\n";

			while ($row = $db->FetchArray($result)) {
				$c .= "<form method='post' action='unknown.php'>\n";
				$c .= "<tr>\n";
					$c .= "<td valign=top>\n";
					if (EMPTY($row['input'])) {
						$c .= "EMPTY";
					}
					else {
						$c .= $row['input'];
					}
					$c .= "</td>\n";
					$c .= "<td valign=top>\n";
					for ($i=0;$i<10;$i++) {
						$c .= "<input type=text name=template[]><br />\n";
					}
					$c .= "<input type='submit' value='Save'>\n";
					$c .= "</td>\n";
					$c .= "<td valign=top>\n";
					$c .= "<a href=unknown.php?delete=y&id=".$row['id'].">Delete</a>\n";
					$c .= "</td>\n";
				$c .= "</tr>\n";
				$c .= "<input type=hidden name=id value='".$row['id']."'>\n";
				$c .= "</form>\n";
			}

			$c .= "</table>\n";
		}
		return $c;
	}
	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
}
?>