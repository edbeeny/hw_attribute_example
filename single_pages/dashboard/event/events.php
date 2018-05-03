<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php if ($controller->getTask() == 'add' ||
    $controller->getTask() == 'edit' ||
    $controller->getTask() == 'submit') {

    ?>

    <form method="post" action="<?= $view->action('submit') ?>">
        <?php echo $token->output('submit') ?>
        <?php echo $form->hidden('eID', $eID) ?>


        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <?= $form->label("eName", t("Event Name")); ?>
                    <?= $form->text("eName", $eName); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= $form->label("eDesc", t("Event Description")); ?><br>
            <?php
            $editor = Core::make('editor');
            echo $editor->outputStandardEditor('eDesc', $eDesc);
            ?>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group">
                    <?= $form->label("eDateFrom", t("Event From:")); ?><br>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                        <?= \Core::make('helper/form/date_time')->date('eDateFrom', $eDateFrom); ?>
                    </div>
                </div>
                <style>
                    #ui-datepicker-div {
                        z-index: 100 !important;
                    }
                </style>
            </div>

            <div class="col-xs-4">
                <div class="form-group">
                    <?= $form->label("eDateTo", t("Event To:")); ?><br>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                        <?= \Core::make('helper/form/date_time')->date('eDateTo', $eDateTo); ?>
                    </div>
                </div>
                <style>
                    #ui-datepicker-div {
                        z-index: 100 !important;
                    }
                </style>
            </div>
        </div>

        <?php

        if (count($attribs) > 0) {
            foreach ($attribs

                     as $ak) {
                if (is_object($event)) {
                    $caValue = $event->getAttributeValueObject($ak);
                }
                ?>

                <div class="form-group">
                    <?= $ak->render('label'); ?>
                    <div class="input">
                        <?= $ak->render('composer', $caValue, true) ?>
                    </div>
                </div>


            <?php } ?>

        <?php } else { ?>
            <em><?= t('You haven\'t created Event attributes') ?></em>

        <?php } ?>


        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo URL::to('/dashboard/event/events') ?>"
                   class="btn btn-default pull-left"><?= t('Cancel') ?></a>
                <?php if (isset($renID)) { ?>
                    <?php echo $form->submit('save', t('Save'), array('class' => 'btn btn-primary pull-right')) ?>
                <?php } else { ?>
                    <?php echo $form->submit('add', t('Add'), array('class' => 'btn btn-primary pull-right')) ?>
                <?php } ?>
            </div>
        </div>
    </form>

    <?php if (isset($eID)) { ?>
        <div class="ccm-dashboard-header-buttons">
            <button data-dialog="delete-entity" class="btn btn-danger"><?php echo t("Delete") ?></button>
        </div>

        <div style="display: none">
            <div id="ccm-dialog-delete-entity" class="ccm-ui">
                <form method="post" class="form-stacked" action="<?= $view->action('delete') ?>">
                    <?php echo $token->output('delete') ?>
                    <?php echo $form->hidden('eID', $eID) ?>
                    <p><?= t('Are you sure? This action cannot be undone.') ?></p>
                </form>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            onclick="$('#ccm-dialog-delete-entity form').submit()"><?= t('Delete') ?></button>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $('button[data-dialog=delete-entity]').on('click', function () {
                jQuery.fn.dialog.open({
                    element: '#ccm-dialog-delete-entity',
                    modal: true,
                    width: 320,
                    title: '<?=t("Delete Entity")?>',
                    height: 'auto'
                });
            });
        </script>


    <?php } ?>

<?php } else { ?>

    <?php if (count($entries)) { ?>
        <div data-search-element="results">
            <div class="table-responsive">
                <table class="ccm-search-results-table">
                    <thead>
                    <tr>
                        <th><span><?php echo t('Event ID') ?></span></th>
                        <th><span><?php echo t('Name') ?></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($entries as $e) {
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo URL::to('/dashboard/event/events/edit', $e->getEventID()) ?>">
                                    <?php echo h($e->getEventID()) ?>
                            </td>
                            </a>
                            <td>
                                <a href="<?php echo URL::to('/dashboard/event/events/edit', $e->getEventID()) ?>">
                                    <?php echo h($e->getEventname()) ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ccm-search-results-pagination">
            <?php print $pagination->renderDefaultView(); ?>
        </div>


    <?php } else { ?>

        <p><?php echo t("No results found.") ?></p>

    <?php } ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?= \URL::to('/dashboard/event/events/', 'add') ?>"
           class="btn btn-primary"><?= t("Add Event") ?></a>
    </div>
<?php }
?>
