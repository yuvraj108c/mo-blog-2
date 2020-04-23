<?php
    require("config.php");
    require("includes/Header.php");
    session_start();
    
    $header = new Header("create","create.css");
    $header->output();

    ?>

<body>
    <?php
        $currentPost =  file_get_contents(SERVER_URL."/server/posts/id/".$_GET["id"]);
        $currentPost = simplexml_load_string($currentPost);
        echo $currentPost;
    ?>

    <?php include "includes/navbar.php"; ?>

    <div id="wrapper">
        <div class="ui attached message">
            <div class="header">
                Edit Post
            </div>
        </div>
        <form class="ui form attached fluid segment" method="POST" action="<?php echo SERVER_URL.'/server/posts' ?>">
            <input type="hidden" name="type" value="update" />
            <div class="field">
                <label>Title</label>
                <input type="text" placeholder="Title" name="title" value="<?php echo($currentPost->title) ?>" required>
            </div>
            <div class="field">
                <label>Description</label>
                <textarea placeholder="Description" name="descri"
                    required><?php echo($currentPost->description) ?></textarea>
            </div>
            <div class="field">
                <label>Category</label>
                <input type="text" placeholder="Category" name="cat" value="<?php echo($currentPost->category) ?>"
                    required>
            </div>
            <div class="field">
                <label>Image URL</label>
                <input type="text" placeholder="Image URL" name="imgURL" value="<?php echo($currentPost->imageUrl) ?>"
                    required>
            </div>

            <button class="ui blue submit button" type="submit" name="save" value="<?php echo($currentPost->id) ?>">Save
    </div>
    </form>
    </div>
</body>