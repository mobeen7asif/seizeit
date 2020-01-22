

<style>
    ul {list-style: none;}
</style>
<header class="header">
    <div class="topNav">
        <?php if(\Illuminate\Support\Facades\Auth::check()) { ?>
      <h2>SeizeIT</h2>
        <?php  }
        else{?>
            <ul class="pf">
            <li><a  class="heading-top" href="<?php echo asset('/login'); ?>">SeizeIT</a></li>
        </ul>
        <?php }
        ?>
    </div>

</header>


