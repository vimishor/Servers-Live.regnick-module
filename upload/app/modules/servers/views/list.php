
<div id="content-wrapper" class="span12 box-3d">
    <div id="content">
        <div class="header">
            <h2><?php echo $page_title; ?></h2>
            <p class="subheader"><?php echo $page_subtitle; ?></p>
        </div>
        <div class="content-data">
            <table class="table table-striped table-bordered table-condensed table-servers">
            <thead>
                <tr>
                    <th style="width: 14px;" class="center">#</th>
                    <th><?php echo lang('server'); ?></th>
                    <th style="width: 40px;" class="center">Map</th>
                    <th style="width: 20px;" class="center">Players</th>
                    <th style="width: 40px;" class="center">Ping</th>
                    <th style="width: 100px;" class="center"><?php echo lang('view'); ?></th>
                    <th style="width: 20px;">Connect</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$servers): ?>
                <tr>
                    <td colspan="7" style="text-align: center;"><?php echo lang('no_results'); ?>.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($servers as $server): ?>
                    <tr class="server" data-server-address="<?php echo $server->address; ?>">
                        <td class="center"><?php echo $server->ID; ?></td>
                        <td><?php echo ($server->name != '') ? strtolower($server->name) : strtolower($server->address); ?></td>
                        <td class="center" id="map"><img src="<?php echo $module_assets; ?>/img/ajax-loader_small.gif"></td>
                        <td class="center" id="players"><a href="#show-players" class="show-players"><img src="<?php echo $module_assets; ?>/img/ajax-loader_small.gif"></a></td>
                        <td class="center" id="ping"><img src="<?php echo $module_assets; ?>/img/ajax-loader_small.gif"></td>
                        <td><a rel="tooltip" title="<?php echo lang('server_team'); ?>" href="<?php echo site_url('server/'.$server->ID.'/team/'); ?>"><?php echo lang('team');?></a> | <a rel="tooltip" title="<?php echo lang('server_members');?>" href="<?php echo site_url('server/'.$server->ID.'/members/'); ?>"><?php echo lang('members');?></a></td>
                        <td class="center">
                            <a rel="tooltip" title="<?php echo lang('connect_with_hlsw'); ?>" href="hlsw://<?php echo $server->address; ?>"><img src="<?php echo $module_assets; ?>/img/icon_hlsw.png">
                            <a rel="tooltip" title="<?php echo lang('connect_with_steam'); ?>" href="steam://connect/<?php echo $server->address; ?>"><img src="<?php echo $module_assets; ?>/img/icon_steam.png"></a>
                        </td>
                    </tr>
                    <tr class="players hide" data-server-address="<?php echo $server->address; ?>">
                        <td colspan="7" class="nested">
                            <table class="table table-bordered table-condensed table-players">
                                <thead>
                                    <th colspan="5">Nickname</th>
                                    <th style="width: 6px;" class="center">Score</th>
                                    <th style="width: 10px;" class="center">Online</th>
                                </thead>
                                <tbody>
                                    <!-- online players -->
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            </table>
            
            <?php echo $this->pagination->create_links(); ?>
            
        </div>
    </div><!-- /#content -->
</div><!-- /#content-wrapper -->
