<# extends base #>

<# block title #>CI Chinese<# /block #>
<# block body #>
    <?php echo $output; ?>
    <?php echo $this->load->view('sidebar', array('a' => 'aaa'), true); ?>
<# /block #>