<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**********comments*********/

$img_id         = trim(htmlspecialchars($_POST['image_id'])); 
$img_user       = trim(htmlspecialchars($_POST['image_user']));
$comment        = htmlspecialchars($_POST['commet_txt']);

    if (isset($_SESSION['loggedin']) === true)
			{
				echo '</div>';
				echo '
					<form action="comment.php" id="commentform'.$img_id.'" method="POST">
						<input type="hidden" name="image_id" value="' . $img_id . '"> 
						<input type="hidden" name="image_user" value="' . $img_user . '">
						<textarea name="commet_txt" form="commentform'.$img_id.'"></textarea>
						<br>
							<input type="submit">
					</form>
					';
			}
				echo '
					<br>
					<table>';
					
				for ($j=0; $j < sizeof($comments); $j++) 
				{ 
					$comment = $comments[$j]['comment'];
					$comment_by = $comments[$j]['Username'];
					
					echo'
						<tr>
							<td>'
								. $comment_by . 
								'<td>'
								. $comment . 
								'</td>' .
							'</td>
						</tr>
						';
				}
			echo '
				</table>
				 ';
            ?>
?>