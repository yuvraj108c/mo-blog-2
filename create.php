<?php
    require("config.php");
    require("includes/Header.php");
    session_start();

    $header = new Header("create","create.css");
    $header->output();

?>

<body>

    <?php include "includes/navbar.php"; ?>

    <div id="wrapper">
        <div class="ui attached message">
            <div class="header">
                Create Post
            </div>
        </div>
        <form class="ui form attached fluid segment" method="POST" action="<?php echo SERVER_URL.'/server/posts' ?>">
            <input type="hidden" name="type" value="create" />

            <div class="field">
                <label>Title</label>
                <input type="text" placeholder="Title" name="title" value="Test Post" required>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea placeholder="Description" name="descri" required>Thisis a description</textarea>
            </div>
            <div class="field">
                <label>Category</label>
                <input type="text" placeholder="Category" name="cat" value="Music" required>
            </div>
            <div class="field">
                <label>Image URL</label>
                <input type="text" placeholder="Image URL" name="imgURL"
                    value="https://voicesofbaltimorecom.files.wordpress.com/2018/07/news.jpg" required>
            </div>

            <button class="ui blue submit button" type="submit" name="save" id="save" value="save">Save
    </div>
    </form>
    </div>
</body>