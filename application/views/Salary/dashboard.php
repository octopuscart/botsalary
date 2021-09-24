<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>





<?php
$this->load->view('layout/footer');
?>


<script>
    $(document).ready(function () {

        Dashboard.init();
        DashboardV2.init();
    });
</script>
<script>
    $(function () {
<?php
$checklogin = $this->session->flashdata('checklogin');
if ($checklogin['show']) {
    ?>
            $.gritter.add({
                title: "<?php echo $checklogin['title']; ?>",
                text: "<?php echo $checklogin['text']; ?>",
                image: '<?php echo base_url(); ?>assets/emoji/<?php echo $checklogin['icon']; ?>',
                            sticky: true,
                            time: '',
                            class_name: 'my-sticky-class '
                        });
    <?php
}
?>
                })







</script>