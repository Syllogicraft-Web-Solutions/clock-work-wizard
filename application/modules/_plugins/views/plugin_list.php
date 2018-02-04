<?php

    $plugins = $page['plugins'];
    $not_installed = $page['not_installed'];

?>
<section class="w3-container">

    <?php if (isset($page['plugin_change_message'])) { ?>

        <div class="w3-panel <?= $page['plugin_change_message']['alert_type'] ?> w3-round w3-card w3-padding">
            <?= $page['plugin_change_message']['message'] ?>
        </div>
    <?php } ?>

    <div class="w3-container" style="height: 50%;">
        <h4>Installed Plugins</h4>
        <table style="width:100%;" class="w3-table w3-bordered w3-responsive w3-small">
            <thead>
                <tr class="w3-theme">
                    <th>Plugin</th>
                    <th>Status</th>
                    <th>URI</th>
                    <th>Version</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Data</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($plugins) {
                        foreach($plugins as $k => $p) {
                            $action = $p->status ? 'deactivate' : 'activate';
                            $status = $p->status ? 'Enabled' : 'Disabled';
                            $button = $p->status ? 'Disable' : 'Enable';
                ?>
                <tr>
                    <?php if ($p->status) { ?>
                            <td><a href="<?= base_url('plugin-settings/' . $p->system_name . '?plugin=' . $p->system_name) ?>"><strong><?= $p->name ?></strong></a></td>
                    <?php } else { ?>
                            <td><?= $p->name ?></td>
                    <?php } ?>
                    <td><?php echo $status; ?></td>
                    <td><?php echo '<a href=' . $p->uri . '" target="_blank">' . $p->uri . '</a>'; ?></td>
                    <td><?php echo $p->version; ?></td>
                    <td><?php echo $p->description; ?></td>
                    <td><?php echo '<a href=' . $p->author_uri . '" target="_blank">' . $p->author . '</a>'; ?></td>
                    <td><pre><?php echo ($p->data ? print_r(unserialize($p->data), TRUE) : 'No Data'); ?></pre></td>
                    <td>
                        <form method="post" action="<?= base_url('_plugins') ?>">
                            <input type="hidden" name="plugin_name" value="<?= $p->system_name ?>">
                            <button name="action_type" value="<?= $action ?>" class="w3-button w3-hover-theme">
                                <?= $button ?>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php 
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

<?php 
    if ($not_installed) { ?>
    <div class="w3-container" style="height: 50%;">
        <h4>Not Installed Plugins</h4>
        <table style="width:100%;" class="w3-table w3-bordered w3-small">
            <thead>
                <tr class="w3-orange">
                    <th>Plugin</th>
                    <th>Desciption</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($not_installed) {
                        foreach($not_installed as $k => $p): ?>
                <tr>
                    <td><?php echo $p; ?></td>
                    <td>Installed into the app, not into the database</td>
                    <td>
                        <form method="post" action="<?= base_url('_plugins') ?>" style="display: flex;">
                            <select name="install_type" class="w3-select select-style w3-border-theme">
                                <option>Select action...</option>
                                <option value="install">Install to database</option>
                                <option value="install_activate">Install to database and activate</option>
                            </select>
                            <input type="hidden" name="plugin" value="<?= $p ?>">
                            <button name="installer" class="w3-button w3-theme-action w3-hover-theme w3-theme-action">Run</button>
                        </form>
                    </td>
                </tr>
                <?php 
                        endforeach; 
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>
</section>