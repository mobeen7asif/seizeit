<aside class="sideBar">

    <style>
        .custom-form{
            padding: 0 15px;
            overflow: hidden;
        }
        .custom-form input[type="submit"]{
            padding:0;
            background:none;
            border:none;
            color:#fff;
        }
        .custom-file-btn{ display: none !important; }
        .custom-label{cursor:pointer;}
    </style>
    <nav class="mainNav">
        <ul class="navList">
            <li <?php if($title == 'users'){echo "class='active'";}?> ><a href="<?php echo asset('/users'); ?>">Users</a></li>
            <li <?php if($title == 'admins'){echo "class='active'";}?> ><a href="<?php echo asset('/admins'); ?>">Admins</a></li>
            <!--<li <?php /*if($title == 'welcome'){echo "class='active'";}*/?> ><a href="<?php /*echo asset('/welcome'); */?>">Welcome Page</a></li>-->
            <!--<li <?php /*if($title == 'supplements'){echo "class='active'";}*/?> ><a href="<?php /*echo asset('/supplements'); */?>">Supplemental Material</a></li>-->
            <li <?php if($title == 'uni'){echo "class='active'";}?> ><a href="<?php echo asset('/uni'); ?>">Universities</a></li>
            <li <?php if($title == 'majors'){echo "class='active'";}?> ><a href="<?php echo asset('/majors');?>">Majors</a></li>
            <li <?php if($title == 'categories'){echo "class='active'";}?> ><a href="<?php echo asset('/categories');?>">Categories</a></li>
            <li <?php if($title == 'sub_categories'){echo "class='active'";}?> ><a href="<?php echo asset('/sub/categories');?>">Sub Categories</a></li>
            <li <?php if($title == 'links'){echo "class='active'";}?> ><a href="<?php echo asset('/links');?>">Links</a></li>
            <li><a href="<?php echo asset('/logout'); ?>">Logout</a></li>
        </ul>
    </nav>
    <sidebar class="copy">&copy; Copyright <?=date('Y')?>
<!--    <div class="codingpixel">-->
<!--        Designed & Developed by <a href="http://codingpixel.com" target="_blank">CodingPixel</a>-->
<!--    </div>-->
    </sidebar>
</aside>
<script src="<?php echo asset('/'); ?>/js/jquery.min.js"></script>
<script>
    var base_url = "<?php echo url('/'); ?>";
    $("#profile_photo").change(function (event){
        var data = event.target.files;
        var image = new FormData(event.target);
        image.append('image',data[0]);
        image.append('_token', "<?php echo csrf_token(); ?>");
        $.ajax({
            url: base_url + '/add/profile_image',
            method : "POST",
            data: image,
            contentType:false,
            processData:false,
            success: function(data){
                data = JSON.parse(data);
                $('#profile_image').attr('src',base_url + data);
            }
        });

    });

</script>


