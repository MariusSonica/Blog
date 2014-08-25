<?php
include_once 'db.inc.php';
class Comments
{
// Our database connection
    public $db;
// Upon class instantiation, open a database connection
    public function __construct()
    {
// Open a database connection and store it
        $this->db = new PDO(DB_INFO, DB_USER, DB_PASS);
    }
// Display a form for users to enter new comments with
public function showCommentForm($blog_id)
{
    return <<<FORM
<form action="/inc/update.inc.php"
method="post" id="comment-form">
<fieldset>
<legend>Post a Comment</legend>
<label>Name
<input type="text" name="name" maxlength="75" />
</label>
<label>Email
<input type="text" name="email" maxlength="150" />
</label>
<label>Comment
<textarea rows="10" cols="45" name="comment"></textarea>
</label>
<input type="hidden" name="blog_id" value="$blog_id" />
<input type="submit" name="submit" value="Post Comment" />
<input type="submit" name="submit" value="Cancel" />
</fieldset>
</form>
FORM;
}
    // Save comments to the database
    public function saveComment($p)
    {
        // Sanitize the data and store in variables
        $blog_id = htmlentities(strip_tags($p['blog_id']),ENT_QUOTES);
        $name = htmlentities(strip_tags($p['name']),ENT_QUOTES);
        $email = htmlentities(strip_tags($p['email']),ENT_QUOTES);
        $comments = htmlentities(strip_tags($p['comment']),ENT_QUOTES);
        // Keep formatting of comments and remove extra whitespace
        $comment = nl2br(trim($comments));
        // Generate and prepare the SQL command
        $sql = "INSERT INTO comments (blog_id, name, email, comment)
                VALUES (?, ?, ?, ?)";
        if($stmt = $this->db->prepare($sql))
        {
            // Execute the command, free used memory, and return true
            $stmt->execute(array($blog_id, $name, $email, $comment));
            $stmt->closeCursor();
            return TRUE;
        }
        else
        {
            // If something went wrong, return false
            return FALSE;
        }
    }
}
?>