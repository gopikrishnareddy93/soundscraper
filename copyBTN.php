<?php 
$this->Html->css('bulma.min.css');
$this->Html->addCrumb('Clients'); ?>
<style>
.fa-copy {
  display: none;
}

.show_hover_img:hover .fa-copy {
  display: inline;
}

.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 140px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 150%;
    left: 50%;
    margin-left: -75px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>
<div class="evareportheader">
    <div id="evareportname">Clients</div>
</div>
<div class="clear"></div>
<div class="evareporttabulator">
        <div class="actions2"><br>
            <div id="ActionTitle">Actions: </div>
            <div id="ActionText">
                <ul>
                <?php if ($group_is_admin || $group_is_partner_admin) : ?>
                    <li><?php echo $this->Html->link(__('New Client'), array('action' => 'add')); ?></li>
                <?php endif; ?>

                <?php if ($group_is_admin) : ?>
                    <li><?php echo $this->Html->link(__('Migrate QB Client'), array('action' => 'migrate_from_qb')); ?></li>
                    <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
                <?php endif; ?>
                <?php if ($group_is_partner_admin) : ?>
                <li><?php echo $this->Html->link(__('ESS Dashboard'), array('controller' => 'clients', 'action' => 'ess_dashboard')); ?> </li>
                    <li><?php echo $this->Html->link(__('Registered Users'), array('controller' => 'partners', 'action' => 'registered_users')); ?></li>
                    <?php if ($currentUser['Partner']['aad_enable'] == true) : ?>
                    <li><?php echo $this->Html->link(__('Configure AAD Sync'), array('controller' => 'partner_messages', 'action' => 'index')); ?></li>
                    <?php endif; ?>
                    <?php if ($this->Session->read('Auth.User.allow_ess') == true) { ?>
                    <li><?php echo $this->Html->link(__('Switch to Manager'), array('controller' => 'users', 'action' => 'switch_manager')); ?></li>
                    <?php 
                } ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if ($group_is_admin) : ?><br><br>
            <?php endif; ?>
            <div style="margin-right: 10px;margin-top: -5px;margin-bottom: 10px;">
            <?php if ($group_is_partner_admin) : ?>  
                <?php echo $this->Html->link($this->Html->image('Test Demo EVA.png', array('class' => 'eva_demo')), 'https://testdriveeva.pii-protect.com/users/login/evademo', array('escape' => false, 'target' => '_blank')); ?><br>
               <?php endif; ?>
           </div>
        </div><br>  
    <div class="evaReportDetails">
    <?php echo $this->Html->link($this->Html->image('Partner Resource Button.png', array('class' => 'new_tab_link')), 'https://www.breachsecurenow.com/partner-resources-marketing-content/?pw=rX345)kf$ax3rDfgg!', array('escape' => false, 'target' => '_blank')); ?>
    <?php if ($currentUser['Partner']['distributor'] == 'BSN') { ?>
    <?php echo $this->Html->link($this->Html->image('Purchase BPP.png', array('class' => 'new_tab_link')), 'http://www.breachsecurenow.com/store-and-bpps/?pw=G5f4sdCHG85!', array('escape' => false, 'target' => '_blank')); ?>
    <?php 
} ?>
        <?php echo $this->element('index_search'); ?>
    <table class="essfullreport">
        <tr>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('account_type'); ?></th>

            <th><?php echo $this->Paginator->sort('admin_account', 'Manager Code'); ?></th>
            <th><?php echo $this->Paginator->sort('user_account', 'Employee Code'); ?></th>
            <th><?php echo $this->Paginator->sort('risk_assessment_status', 'RA Completed'); ?></th>
            <?php if ($group_is_admin) : ?>
            <th><?php echo $this->Paginator->sort('whitelabel'); ?></th>
            <?php endif; ?>
            <th><?php echo $this->Paginator->sort('user_count', 'Registered Users'); ?></th>
            <?php if ($group_is_admin) : ?>
            <th><?php echo $this->Paginator->sort('is_real', 'Client Type'); ?></th>
            <?php endif; ?>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th><?php echo $this->Paginator->sort('total_breaches', 'Password Breaches'); ?></th>
            <th><?php echo $this->Paginator->sort('active', 'Active'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>

        <?php foreach ($clients as $client) : ?>
            <tr>
                <td>
                <div class="show_hover_img">
                <?php echo $client['Client']['name']; ?>
                <div class = "<?php echo $client['Client']['id']; ?>"><?php echo $client['Client']['id']; ?>                
                <div class="tooltip">
                <i class="fa fa-copy" onclick = "copyTextToClipboard(<?php echo $client['Client']['id'] ?>)" onmouseout="outFunc(<?php echo $client['Client']['id'] ?>)"> 
                    <span class="tooltiptext" id="<?php echo "myTooltip-" . $client['Client']['id']; ?>">Copy to clipboard</span>
                </i>
                </div> 
                </div>
                </td>
                <td><?php echo $client['Client']['account_type']; ?></td>
                <td><?php echo $client['Client']['admin_account']; ?></td>
                <td><?php echo $client['Client']['user_account']; ?></td>
                <?php if (!empty($client['Client']['risk_assessment_status'])) : ?>
                    <td class="completed">
                        <?php echo $this->Time->format('m/d/y', $client['Client']['risk_assessment_status']); ?>

                    </td>
                <?php else : ?>
                    <td></td>
                <?php endif; ?>
                <?php if ($group_is_admin) : ?>
                <td><?php echo ($client['Partner']['whitelabel'] ? 'Y' : 'N'); ?></td>
                <?php endif; ?>
                <td><?php echo $client['Client']['user_count']; ?></td>
                <?php if ($group_is_admin) : ?>
                <td><?php echo ($client['Client']['is_real']) ? 'Production' : 'Test'; ?></td>
                <?php endif; ?>
                <td><?php echo $this->Time->format('m/d/y g:i a', $client['Client']['created']); ?></td>
                <td><?php echo $client['Client']['total_breaches']; ?></td>
                <?php if ($client['Client']['active']) : ?>
                    <td class="active">Yes</td>
                <?php else : ?>
                    <td class="inactive">No</td>
                <?php endif; ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $client['Client']['id']));
                    echo $this->Html->link(__('Edit'), array('action' => 'edit', $client['Client']['id']));
                    if ($group_is_admin) {
                        echo $this->element(
                            'delete_link',
                            array('title' => 'Delete', 'name' => 'Client', 'id' => $client['Client']['id'])
                        );
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
    <?php echo $this->element('index_page_controls'); ?>
    </div>
</div>
<script>

function fallbackCopyTextToClipboard(text) {
    var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand("copy");  // Security exception may be thrown by some browsers.
        } catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        } finally {
            document.body.removeChild(textarea);
        }

        var tooltip = document.getElementById("myTooltip-" + text);
        tooltip.innerHTML = "Copied: " + text;
}

function copyTextToClipboard(text) {
if (!navigator.clipboard) {
    fallbackCopyTextToClipboard(text);
    return;
  }

  navigator.clipboard.writeText(text).then(function() {
    console.log('Copying to clipboard was successful!');
    
  var tooltip = document.getElementById("myTooltip-" + text);
  tooltip.innerHTML = "Copied: " + text;
  }, function(err) {
    console.error('Could not copy text: ', err);
  });
}

function outFunc(text) {
  var tooltip = document.getElementById("myTooltip-" + text);
  tooltip.innerHTML = "Copy to clipboard";
}
</script>
