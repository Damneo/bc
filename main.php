<?php
	include("simple_html_dom.php");


	function getInfos() {

		$date = "11%2F03%2F2016";
		$url = "https://www.betclic.fr/calendrier-0?From=".$date."&SortBy=HighestOdds&Live=false&MultipleBoost=true&MultipleBoost=false&Competitions.Selected=1-0&StartIndex=0&Search=";
		$content = file_get_html($url);

		$games = array();

		foreach($content->find('div.match-entry') as $match) {

		    $game = array();

		    $game["date"] = $match->find("div.match-time", 0)->plaintext;
		    $teams = $match->find("div.match-details", 0)->find("a.match-name", 0)->plaintext;

		    $game["team1"] = explode(" - ", $teams)[0];
		    $game["team2"] = explode(" - ", $teams)[1];
		    $game["win1"] =  $match->find("div.match-odds", 0)->find("div.match-odd", 0)->plaintext;
		    $game["draw"] = $match->find("div.match-odds", 0)->find("div.match-odd", 1)->plaintext;
		    $game["win2"] = $match->find("div.match-odds", 0)->find("div.match-odd", 2)->plaintext;
		    $game["win1"] = str_replace(",", ".", $game["win1"]);
		    $game["draw"] = str_replace(",", ".", $game["draw"]);
		    $game["win2"] = str_replace(",", ".", $game["win2"]);
		  	$game["diff"] = getDiffCotes($game["win1"], $game["win2"]);

		    array_push($games, $game);

		}

		return $games;
	}

	function displayTable($games, $idTable, $diff) {

		$coteCumulee = 1;
		$cpt = 0;

		echo "<table id='".$idTable."'>";
		echo "<tr>";
		echo "<th>#</th>";
		echo "<th>Date</th>";
		echo "<th>Equipe 1</th>";
		echo "<th>Equipe 2</th>";
		echo "<th>Gagne 1</th>";
		echo "<th>Draw</th>";
		echo "<th>Gagne 2</th>";
		echo "<th>Diff cote</th>";
		echo "<th>Cote cumulée</th>";
		echo "</tr>";
		foreach ($games as $game) {
			$cpt += 1;
			$coteCumulee = $coteCumulee * str_replace(",", ".", min($game['win1'],$game['win2']));

			echo "<tr class='".getColorDiffCote($game['diff'])."'>";
			echo "<td>".$cpt."</td>";
			echo "<td>".$game["date"]."</td>";
			echo "<td>".$game["team1"]."</td>";
			echo "<td>".$game["team2"]."</td>";
			echo "<td>".$game["win1"]."</td>";
			echo "<td>".$game["draw"]."</td>";
			echo "<td>".$game["win2"]."</td>";
			echo "<td>".$game["diff"]."</td>";
			echo "<td>".round($coteCumulee, 2)."</td>";
			echo"</tr>";
		}
		echo "</table>";
	}

	function getDiffCotes($cote1, $cote2) {

		$res = $cote1 - $cote2;
		return ($res < 0) ? $res * -1 : $res;
	}

	function getColorDiffCote($coteDiff) {

		if ($coteDiff >=14) {
			
			return "green";

		} else if ($coteDiff >= 9) {

			return "orange";

		} else if ($coteDiff >= 8) {

			return "red";
		} else {

			return "";
		}
	}
