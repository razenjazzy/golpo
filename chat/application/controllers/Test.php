<?php

require_once('Home.php');

class Test extends Home
{
    public $gmb;
    public $client;

    public function __construct()
    {
        parent::__construct();
       // $this->load->library('google_my_business');
       // $this->gmb = $this->google_my_business;
        //$this->client = $this->gmb->client;
    }

    public function index()
    {
        echo $this->gmb->login_button();
    }


    public function account_information()
    {
        $account = $this->gmb->accountInformation();
        // foreach ($account as $info) {
        //     echo $info->getName();
        // }

        echo '<pre>';
        print_r($account);
    }

    public function list_accounts_locations()
    {
        $locations = $this->gmb->listAccountsLocations('accounts/107745512734031207626');

        echo '<pre>';
        print_r($locations);
    }

    public function posts_list()
    {
        $posts_list = $this->gmb->postsList('accounts/107745512734031207626/locations/14692206365244175995');

        $standard_posts = [];
        $event_posts = [];
        $offer_posts = [];
        foreach ($posts_list as $key => $post) {
            // echo $post->getName() . '<br>';
            // echo $post->getSummary() . '<br>';
            // echo $post->getState() . '<br>';
            // echo '<hr>';

            $topicType = $post->getTopicType();
            if ('STANDARD' == $topicType) {
                $standard_posts[$key] = $post;
            } elseif ('EVENT' == $topicType) {
                $event_posts[$key] = $post;
            } elseif ('OFFER' == $topicType) {
                $offer_posts[$key] = $post;
            }
        }

        echo 'Post Numbers: ' . count($posts_list) . '<br>';
        echo '<pre>';
        print_r($standard_posts);
        echo '<hr>';
        print_r($event_posts);
        echo '<hr>';
        print_r($offer_posts);
    }

    public function reviews_list()
    {
        $reviews_list = $this->gmb->reviewsList('accounts/107745512734031207626/locations/14692206365244175995');
        $weekly = new DateTime('today -7 days');
        $monthly = new DateTime('today -1 month');


        echo "<pre>";
            print_r($reviews_list);


            return; 
            

        $one_star = 0;
        $two_star = 0;
        $three_star = 0;
        $four_star = 0;
        $five_star = 0;
        $weekly_data = [];

        foreach ($reviews_list as $key => $review) {
            echo $review->getName() . '<br>';
            echo $review->getReviewer()->getDisplayName() . '<br>';
            echo $review->getReviewer()->getProfilePhotoUrl() . '<br>';
            echo $review->getStarRating() . '<br>';
            echo "\t\t" . $review->getReviewReply()->getComment() . '<br>';
            echo "\t\t" . $review->getReviewReply()->getUpdateTime() . '<br>';

            $created_time = new DateTime($review->getCreateTime());
            if ($created_time > $weekly) {
                $weekly_data[$key] = $review;
            }

            $star = $review->getStarRating();
            switch ($star) {
                case 'ONE':
                    $one_star++;
                    break;
                case 'TWO':
                    $two_star++;
                    break;
                case 'THREE':
                    $three_star++;
                    break;
                case 'FOUR':
                    $four_star++;
                    break;
                case 'FIVE':
                    $five_star++;
                    break;
            }
        }

        echo 'Total Reviews: ' . count($reviews_list);
        echo '<hr>';
        echo $one_star;
        echo '<hr>';
        echo $two_star;
        echo '<hr>';
        echo $three_star;
        echo '<hr>';
        echo $four_star;
        echo '<hr>';
        echo $five_star;
        echo '<hr>';
        echo '<pre>';
        print_r($weekly_data);
    }

    public function questions_list()
    {
        $questions_list = $this->gmb->questionsList('accounts/107745512734031207626/locations/14692206365244175995');
        $weekly = new DateTime('today -7 days');
        $monthly = new DateTime('today -1 month');

        $monthly_data = [];
        foreach ($questions_list as $key => $question) {
            // echo $question->getName() . '<br>';
            // echo $question->getAuthor()->getDisplayName() . '<br>';
            // echo $question->getAuthor()->getProfilePhotoUrl() . '<br>';
            // echo $question->getText() . '<br>';
            // var_dump($question->getTopAnswers());
            // echo '<hr>';
            $created_time = new DateTime($question->getCreateTime());
            if ($created_time > $monthly) {
                $monthly_data[$key] = $question;
            }
        }

        echo 'Total Questions: ' . count($questions_list);
        echo '<pre>';
        print_r($monthly_data);
    }

    public function questions_answers_list()
    {
        $questions_answers_list = $this->gmb->questionsAnswersList('accounts/107745512734031207626/locations/14692206365244175995/questions/AIe9_BGhYIk2KhOdF8fekWDvq8JU1cCvkWRRPD6lBDJ91ky3P9U1WtFOwcFQ7D35p6Gs1oFl8LhffrKYjKEhk2TZpoFja82FwGMzk8Gv1V9MyC8NPUDOovIJTpeUgvYucarZhkVrfJDF');
        echo '<pre>';
        print_r($questions_answers_list);

        foreach ($questions_answers_list as $answer) {
            echo $answer->getAuthor()->getDisplayName() . '<br>';
            echo $answer->getText() . '<br>';
            echo '<hr>';
        }
    }

    public function reply_review() {
        $reply_review = $this->gmb->replyReview(
            'accounts/107745512734031207626/locations/14692206365244175995/reviews/AIe9_BGTHfLB7ZAtvlQmidaL-PvDffXSJT4V0X4JV7tFmC-viNqqTM8mnm3ZQ5lDZKyWy6d-z6oJkcq0mOpm15z8jnV9rI64-VPFyCbLSkif5mT78cGlIn4',
            'Thank you very much!'
        );

        echo '<pre>';
        print_r($reply_review);
    }

    public function add_product()
    {
        $create_product = $this->gmb->addProduct(
            'accounts/107745512734031207626/locations/14692206365244175995',
            'Messenger Bot Connectivity : A XeroChat Add-On',
            55,
            69,
            'Just summary',
            [
                'mediaFormat' => 'PHOTO',
                'sourceUrl' => 'https://www.xeroneit.net/upload/portfolio/32/cover.jpg'
            ]
        );

        echo '<pre>';
        print_r($create_product);
    }

    public function location_insights_basic_metric()
    {
        $insights = $this->gmb->locationInsightsBasicMetric(
            'accounts/107745512734031207626',
            ['accounts/107745512734031207626/locations/14692206365244175995'],
            'ALL',
            ['AGGREGATED_DAILY'],
            new DateTime('2019-12-25'),
            new DateTime('2020-01-25')
        );

        echo '<pre>';
        print_r($insights['locationMetrics']);
    }

    public function location_insights_driving_directions_metric()
    {
        $insights = $this->gmb->locationInsightsDrivingDirectionsMetric(
            'accounts/107745512734031207626',
            ['accounts/107745512734031207626/locations/14692206365244175995'],
            'NINETY'
        );

        echo '<pre>';
        print_r($insights);
    }

    public function posts_insights_basic_metric()
    {
        $insights = $this->gmb->postsInsightsBasicMetric(
            'accounts/107745512734031207626/locations/14692206365244175995',
            [
                'accounts/107745512734031207626/locations/14692206365244175995/localPosts/3007696642926571065',
                'accounts/107745512734031207626/locations/14692206365244175995/localPosts/6514266386662340335',
                'accounts/107745512734031207626/locations/14692206365244175995/localPosts/2668380682591982902',
                'accounts/107745512734031207626/locations/14692206365244175995/localPosts/8193662999915111115',
            ],
            'ALL',
            ['AGGREGATED_TOTAL'],
            new \DateTime('2019-12-25'),
            new \DateTime('2020-01-25')
        );

        echo '<pre>';
        print_r($insights);
    }

    public function create_offer()
    {
        $r = $this->gmb->tryOfferPost();
        echo '<pre>';
        print_r($r);
    }




    public function sendinblue_test(){


        echo file_get_contents("https://www.client.multichat.me/upload/image/5/image_5_1582572170149111.jpg"); exit; 

        


        $api_key="5758a9846c48d7af4282780fd6b20eec27b8b1ff58cc66000a8d448603c416fc41426c2e";
        $url="https://konokronok.api-us1.com/";

        $this->load->library("mailchimp_api");

        $response= $this->mailchimp_api-> activecampaign_add_contact($api_key,$url,$email='konok11@xeroneit.net',$firstname='FF',$lastname="LL",$list_id=2);

        $response=json_decode($response,true);

        echo "<pre>";
        print_r($response);



    }
}



