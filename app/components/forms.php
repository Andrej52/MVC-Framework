<?php
// this structure should be edited by you !! 
// chanellog: FORM class W.I.P

function createTopicForm() : void 
{ 
            echo
            '
            <form action="../app/controllers/ad.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="table" value="adds">
                <input type="text" placeholder="nadpis" name="header">
                <input type="text" name="text" placeholder="content">
                <input type="file" accept="image/*"  name="image">
                <input type="file" accept=".docx,.pdf,.xml"  name="doc">
                <input type="submit" value="submit">
            </form>
            ';    
}

function createGalleryForm() : void 
{
   echo
   '
   <form action="../app/controllers/topic_add.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="table" value="galleries">
        <input type="text" placeholder="text1" name="header">
        <textarea name="desc" cols="30" rows="10"></textarea>
        <input type="file" accept="image/*"    name="img[]" multiple >
        <!--
            multiple document input
        <input type="file" accept="doc/*"    name="files[]" multiple  >
        -->
        <input type="submit" value="upload">
    </form>
   ';
}
