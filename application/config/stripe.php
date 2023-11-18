<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

/*
 * | -------------------------------------------------------------------
 * |  Stripe API Configuration
 * | -------------------------------------------------------------------
 * |
 * | You will get the API keys from Developers panel of the Stripe account
 * | Login to Stripe account (https://dashboard.stripe.com/)
 * | and navigate to the Developers >> API keys page
 * |
 * |  stripe_api_key            string   Your Stripe API Secret key.
 * |  stripe_publishable_key    string   Your Stripe API Publishable key.
 * |  stripe_currency           string   Currency code.
 */
$config['stripe_api_key'] = 'sk_test_51OAoKQAEiuSYkXpOJ4l8HvdVsV9HfrQUXHSAfPKUAGiarKJCXKgSXThnx2aUzpXZUtbA3wO9DE4ZxHoaFFDzib6M00clBEdBOb';
$config['stripe_publishable_key'] = 'pk_test_51OAoKQAEiuSYkXpOlIv1xK8opGNvmq2QFV1b7pkE24EHeJvzoSReeJ9GU6aXbytFAz35G0IKCEWf5YPEFLA6dvvL00EA3cmzei';
$config['stripe_currency'] = 'usd';