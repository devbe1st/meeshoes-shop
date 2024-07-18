<style>
    img{
        width: 100% !important;
    }
</style>
<main>
    <?php 
    if(isset($result)){
        ?>
        <div id="read-blog">
            <div class="fix-padding">
                <h1><?= $result['title'] ?></h1>
                <?= $result['content'] ?>
            </div>
        </div>
        <?php //HTML
    }else{
        ?><script>window.location.href = '?page=blogs'</script><?php //SCRIPT
    }
    ?>
    <!-- /* -------------------------------- ALL BLOG -------------------------------- */ -->
    <br>
    <!-- /* -------------------------------- ALL BLOG -------------------------------- */ -->
</main>