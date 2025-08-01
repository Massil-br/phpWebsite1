<script>
    <?php if(!empty($benchmarks)):
        foreach($benchmarks as $benchmark):?>
        console.log("<?= $benchmark ?> ");
    <?php endforeach;endif;?>
</script>