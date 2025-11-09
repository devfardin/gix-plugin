<?php
class EXTERNAL_API
{
    public function __construct()
    {
        add_shortcode('rander_external_api', [$this, 'external_api']);
        add_shortcode('rander_placeholder_api', callback: [$this, 'placeholder_api']);
    }
    public function external_api($att)
    {
        $default = [
            'user' => 'devfardin',
        ];
        $atts = shortcode_atts($default, $att);

        ob_start();
        $url = 'https://api.github.com/users/' . $atts['user'];
        $response = wp_remote_get($url, array('timeout' => 5));
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        $transient_key = $atts['user'];
        $cashec_values = get_transient($transient_key);

        if(!$cashec_values && $cashec_values->login !== $data->login) {
            set_transient($transient_key, $data, DAY_IN_SECONDS);
        }
        ?>

        <div>
            <img style="border-radius: 10px" src="<?php echo $cashec_values->avatar_url; ?>" alt="<?php echo $cashec_values->name; ?>">
            <div>
                <h3><?php echo esc_html($cashec_values->name); ?></h3>
                <p><?php echo esc_html($cashec_values->bio) ?></p>
                <a target="_blank" class="btn-primary"
                    style="background: blue; padding: 10px; border-radius: 5px; color:white; font-weight: 500; text-decoration: none;"
                    href="<? echo esc_attr($cashec_values->blog); ?>">Portfolio</a>
                <a target="_blank" class="btn-primary"
                    style="background: blue; padding: 10px; border-radius: 5px; color:white; font-weight: 500; text-decoration: none;"
                    href="<? echo esc_attr($cashec_values->html_url); ?>">Github</a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    public function placeholder_api()
    {
        ob_start();
        $api_url = 'https://jsonplaceholder.typicode.com/posts';
        $response = wp_remote_get($api_url, array('timeout' => 5));
        $body = wp_remote_retrieve_body($response);
        $datas = json_decode($body);
        ?>
        <style>
            .placeholder_wrapper{
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin-top: 40px !important;
            }
            .placeholder_inner{
                border: 1px solid #ddd;
                padding: 10px;
                border-radius: 6px;
            }

        </style>
        <div class="placeholder_wrapper"> 
            <?php
            foreach($datas as $data ) { ?>
                <div class="placeholder_inner">
                    <h3><?php echo esc_html($data->title) ?></h3>
                    <p><?php echo esc_html($data->body); ?></p>
                </div>
            <?php } ?>
        </div>
        <?php



        return ob_get_clean();

    }
}