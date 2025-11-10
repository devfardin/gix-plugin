<?php
class RAPID_API
{
    public function __construct()
    {
        add_shortcode('rander_rapid_api', [$this, 'rapid_api']);

    }
    public function rapid_api()
    {
        ob_start();
        $url = 'https://real-time-news-data.p.rapidapi.com/search?query=Football&limit=10&time_published=anytime&country=US&lang=en';
        $arg = [
            'timeout' => 5,
            'headers' => array(
                "x-rapidapi-host" => "real-time-news-data.p.rapidapi.com",
                "x-rapidapi-key" => "c645f4b9ebmsh14efd9544038f9bp1c50e0jsn81ec98db8858",
            )
        ];
        $response = wp_remote_get($url, $arg);
        $body = wp_remote_retrieve_body($response);
        $http_code = wp_remote_retrieve_response_code($response);
        $datas = json_decode($body);
        $getData =$datas->data;

        if (is_wp_error($response) || !isset($response['response'])) {
            return 'Not Found Data, Error code' . $http_code;
        }
        ?>
        <div class="news-card-wrapper">
            <?php foreach ($getData as $data) { ?>
                <div class="news-card">
                    <div class="news-image">
                        <img src="<?php echo $data->photo_url ?>" alt="News Photo">
                    </div>

                    <div class="news-content">
                        <h2 class="news-title">
                            <a href="<?php echo !empty($data->link) ? $data->link : '#' ?>"
                                target="_blank">
                                <?php echo $data->title ?>
                            </a>
                        </h2>

                        <p class="news-snippet">
                          <?php echo $data->title ?>
                        </p>

                        <div class="news-meta">
                            <div class="author-info">
                                <img src="<?php echo $data->source_logo_url ?>"
                                    alt="Source Icon">
                                <span>By <strong>  <?php echo !empty($data->authors[0]) ? esc_html($data->authors[0]) : 'Unknow'; ?> </strong> - <?php echo !empty($data->source_name)  ? $data->source_name : ''  ?> </span>
                            </div>

                            <div class="news-date">
                                <span>
                                     <?php echo $data->published_datetime_utc ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }
            ?>
        </div>
        <?php

        return ob_get_clean();
    }
}