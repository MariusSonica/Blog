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
}
?>