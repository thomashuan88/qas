<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<p>
    Warning: Github needs your email to be publicly visible for the authentication to work.
</p>

<?php
if (Settings_model::$db_config['oauth2_enabled']) { ?>
    <div class="mg-b-15">
        <?php
        $i=0;
        if ($providers) {
        foreach ($providers as $provider) { ?>
            <div class="mb_share">
                <a href="<?php print base_url(); ?>auth/oauth2/init/<?php print $provider->name; ?>">
                    <div class="button <?php print strtolower($provider->name); ?> slide_y">
                        <div class="icon"><i class="fa fa-<?php print strtolower($provider->name); ?> pd-r-5"></i></div>
                        <div class="slide">
                            <span>
                                <?php print strtolower($provider->name); ?>
                            </span>
                        </div>
                        <div class="native_button">
                            <div class="small text-uppercase">
                                Sign in
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php }} ?>
    </div>

    <div class="clearfix"></div>

    <!--div class="mb_share">
        <a href="">
            <div class="button facebook slide_x">
                <div class="icon"></div>
                <div class="slide">
                    <span>
                        facebook
                    </span>
                </div>
                <div class="native_button">
                    <div class="small text-uppercase">
                        Sign in
                    </div>
                </div>
            </div>
        </a>

        <-div class="button youtube slide_nx">
            <div class="icon"></div>
            <div class="slide">
                    <span>
                        youtube
                    </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
        <div class="button google slide_ny">
            <div class="icon"></div>
            <div class="slide">
            <span>
                google
            </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
        <div class="button linkedin slide_y">
            <div class="icon"></div>
            <div class="slide">
            <span>
                linkedin
            </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
        <div class="button tumblr slide_nx">
            <div class="icon"></div>
            <div class="slide">
            <span>
                tumblr
            </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
        <div class="button github slide_ny">
            <div class="icon"></div>
            <div class="slide">
            <span>
                github
            </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
        <div class="button pinterest slide_x">
            <div class="icon"></div>
            <div class="slide">
            <span>
                pinterest
            </span>
            </div>
            <div class="native_button">
                <div>Content here
                </div>
            </div>
        </div>
    </div-->
<?php } ?>