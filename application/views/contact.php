<style>
.field-error {
  color: red;
  font-size: 12px;
}
</style>
<div id="secondary-content-wrapper">
  <div class="container clearfix">
    <h1 style="padding-top:0px;">Contact</h1>
  </div>
</div>
<div id="content-wrapper">
  <div class="container">
    <div id="columns">
      <div class="columns-inner clearfix">
        <div id="content-column" style="padding-left:50px; padding-right:50px;background:white !important;">
          <div class="content-inner">
            <section id="main-content" style="max-width: 768px;">
              <header id="main-content-header" class="clearfix">
                <h1 id="page-title">Contact US</h1>
              </header>
              <div id="content">
                <div id="block-system-main"
                  class="block block-system no-title odd first last block-count-10 block-region-content block-main">
                  <article id="node-2586282"
                    class="node node-page article odd node-full view-mode-full rendered-by-ds clearfix" role="article">
                    <div class="one-column at-panel panel-display clearfix">
                      <div class="region region-one-main">
                        <div class="region-inner clearfix">
                          <div class="field field-name-body">
                            <?php if (!empty($status)) { ?>
                            <div class="status <?php echo $status['type']; ?>"><?php echo $status['msg']; ?></div>
                            <?php } ?>
                            <?php echo form_error('name', '<p class="field-error">', '</p>'); ?>
                          </div>
                          <form class="google-cse" action="<?= SITE_URL ?>contact" method="post" id="contact-form">
                            <div>
                              <input type="hidden" name="hidden" id="hidden" value="hidden" />
                              <div class="form-container">
                                <div class="form-item my-text form-type-textfield form-item-search-block-form">
                                  <input type="text" name="name" id="contact_name" placeholder="Name"
                                    class="form-text form-input"
                                    value="<?php echo !empty($postData['name']) ? $postData['name'] : ''; ?>"
                                    style="width:100%;" />
                                  <?php echo form_error('name', '<p class="field-error">', '</p>'); ?>
                                </div>
                                <div class="form-item my-text form-type-textfield form-item-search-block-form">
                                  <input type="email" name="email" id="email" placeholder="Email"
                                    class="form-text form-input"
                                    value="<?php echo !empty($postData['email']) ? $postData['email'] : ''; ?>"
                                    style="width:100%;" />
                                  <?php echo form_error('email', '<p class="field-error">', '</p>'); ?>
                                </div>
                                <div class="form-item my-text  form-type-textfield form-item-search-block-form">
                                  <input type="text" name="subject" id="subject" placeholder="Subject"
                                    class="form-text form-input"
                                    value="<?php echo !empty($postData['subject']) ? $postData['subject'] : ''; ?>"
                                    style="width:100%;" />
                                  <?php echo form_error('subject', '<p class="field-error">', '</p>'); ?>
                                </div>
                                <div class="form-item my-text form-type-textfield form-item-search-block-form">
                                  <textarea name="message" id="message" rows='10' placeholder="message"
                                    style="width:100%;"><?php echo !empty($postData['message']) ? $postData['message'] : ''; ?></textarea>
                                  <?php echo form_error('message', '<p class="field-error">', '</p>'); ?>
                                </div>
                              </div>

                              <div class="form-actions my-text form-wrapper" id="edit-actions"
                                style="margin-bottom:50px;display:flex; justify-content:center;">
                                <button type="submit" name="contactSubmit">Send</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
                </article>
              </div>
          </div>
          </section>
        </div>
      </div>

    </div>
  </div>
</div>
</div>