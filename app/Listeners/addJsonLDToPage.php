<?php

namespace SimpleLocator\Listeners;

use SimpleLocator\Repositories\PostRepository;

class addJsonLDToPage
{

    private $postRepo;
    private $locationData;
    private $testimonials;
    private $aggregateRating;

    private $jsonStr;

    public function __construct()
    {
        $this->postRepo = new PostRepository;
        $this->setLocationData();

        $t = new \SimpleLocator\Integrations\Testimonials\Testimonials();
        $this->testimonials = $t->getTestimonialsForLocation($this->locationData['id']);


        $this->generateJsonLD();
        $this->renderView();
    }

    /**
     * Set the location data for use in map
     */
    private function setLocationData()
    {
        //this is from the short code, if you put a zero in for the location post repo will look up the current page
        $options['location'] = 0;

        $this->locationData = $this->postRepo->getLocationData($options);
    }

    private function getReviews()
    {
        $totalRatingPoints = 0;
        $ratingVales = [];
        $reviews = [];

        foreach ($this->testimonials as $key => $testimonial) {
            $ratingValue = $this->convertRating(get_post_meta($testimonial->ID, 'rating', true));
            $totalRatingPoints = $totalRatingPoints + $ratingValue;

            $reviews[] = [
                '@type' => 'Review',
                'author' => $testimonial->post_title,
                'datePublished' => $testimonial->post_date_gmt,
                'description' => get_post_meta($testimonial->ID, 'testimonial_text', true),
                'reviewRating' => [
                    '@type' => 'Rating',
                    'bestRating' => '5',
                    'ratingValue' => $ratingValue,
                    'worstRating' => '1',
                ],
            ];
        }
        $this->aggregateRating =round($totalRatingPoints / count($this->testimonials),2);

        return $reviews;
    }

    /**
     * Convert the text rating to number
     * @param string $rating - spelled out number of starts: five_starts
     * @return int
     */
    private function convertRating($rating)
    {
        switch ($rating)
        {
            case 'five_stars':
                return 5;
            case 'four_stars':
                return 4;
            case 'three_stars':
                return 3;
            case 'two_stars':
                return 2;
            case 'one_star':
                return 1;
            //default if no rating is selected
            case '':
                return 5;
            case 'none':
                return 5;
        }
    }

    public function getImage()
    {
        $thumb_url_array = wp_get_attachment_image_src($this->locationData['id'], 'thumbnail-size', true);
        return $thumb_url_array[0];
    }

    private function generateJsonLD()
    {
        $locationArrayLD = [
          '@id' => '',
          '@context' => 'http://schema.org',
          '@type' => '@LocalBusiness',
          'name' => $this->locationData['title'],
          'url' => $this->locationData['website'],
          'sameAs' => $this->locationData['same_as'],
          'address' => [
              '@type' => 'PostalAddress',
              'addressLocality' => $this->locationData['city'],
              'addressRegion' => $this->locationData['state'],
              'postalCode' => $this->locationData['zip'],
              'streetAddress' => $this->locationData['address'] . ' ' . $this->locationData['address_two'],
          ],
          'telephone' => $this->locationData['phone'],
          'email' => $this->locationData['email'],
          'priceRange' => $this->locationData['price_range'],
          'paymentsAccepted' => $this->locationData['payment_accepted'],
          'logo' => $this->locationData['logo'],
          'areasServered' => $this->locationData['areas_severed'],
          'image' => $this->getImage(),
          'review' => $this->getReviews(),
          'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => $this->aggregateRating,
                'reviewCount' => count($this->testimonials),
          ],
          'openinghours' => 'mo-fr,sa,su ' . $this->locationData['hours_mf_open'] . '-' . $this->locationData['hours_mf_close'] . ','
                                           . $this->locationData['hours_sat_open'] . '-' . $this->locationData['hours_sat_open'] . ','
                                           . $this->locationData['hours_sun_open'] . '-' . $this->locationData['hours_sun_close'],
        ];

        $this->jsonStr = '<script type="application/ld+json">';
        $this->jsonStr .= json_encode($locationArrayLD);
        $this->jsonStr .= '</script>';
    }

    private function renderView()
    {
        echo $this->jsonStr;
    }
}