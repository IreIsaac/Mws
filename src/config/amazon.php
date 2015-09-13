<?php

return [
    'mws' => [
        'enumerations' => [
            'feedStatus' => [
                '_AWAITING_ASYNCHRONOUS_REPLY_' => 'The request is being processed, but is waiting for external information before it can complete.',
                '_CANCELLED_'                   => 'The request has been aborted due to a fatal error.',
                '_DONE_'                        => 'The request has been processed. You can call the GetFeedSubmissionResult operation to receive a processing report that describes which records in the feed were successful and which records generated errors.',
                '_IN_PROGRESS_'                 => 'The request is being processed.',
                '_IN_SAFETY_NET_'               => 'The request is being processed, but the system has determined that there is a potential error with the feed (for example, the request will remove all inventory from a seller\'s account.) An Amazon seller support associate will contact the seller to confirm whether the feed should be processed.',
                '_SUBMITTED_'                   => 'The request has been received, but has not yet started processing.',
                '_UNCONFIRMED_'                 => 'The request is pending.',
            ],
        ],
        'version' => [
            '/'                                => '2009-01-01',
            '/Products/2011-10-01'             => '2011-10-01',
            '/Subscriptions/2013-07-01'        => '2013-07-01',
            '/Orders/2013-09-01'               => '2013-09-01',
            '/CustomerInformation/2014-03-01'  => '2014-03-01',
            '/CartInformation/2014-03-01'      => '2014-03-01',
            '/Finances/2015-05-01'             => '2015-05-01',
        ],
        'paths' => [
        	'/CartInformation/2014-03-01'    =>  [
        		'ListCarts',
				'ListCartsByNextToken',
				'GetCarts',
        	],
            '/CustomerInformation/2014-03-01' => [
                'ListCustomers',
                'ListCustomersByNextToken',
                'GetCustomersForCustomerId',
            ],
            '/Finances/2015-05-01' => [
                'ListFinancialEventGroups',
                'ListFinancialEventGroupsByNextToken',
                'ListFinancialEvents',
                'ListFinancialEventsByNextToken',
                'GetServiceStatus',
            ],
            '/Products/2011-10-01' => [
                'ListMatchingProducts',
                'GetMatchingProduct',
                'GetMatchingProductForId',
                'GetCompetitivePricingForSKU',
                'GetCompetitivePricingForASIN',
                'GetLowestOfferListingsForSKU',
                'GetLowestOfferListingsForASIN',
                'GetMyPriceForSKU',
                'GetMyPriceForASIN',
                'GetProductCategoriesForSKU',
                'GetProductCategoriesForASIN',
            ],
            '/Subscriptions/2013-07-01' => [
                'RegisterDestination',
                'DeregisterDestination',
                'ListRegisteredDestinations',
                'SendTestNotificationToDestination',
                'CreateSubscription',
                'GetSubscription',
                'DeleteSubscription',
                'ListSubscriptions',
                'UpdateSubscription',
            ],
            '/Orders/2013-09-01' => [
                'ListOrders',
                'ListOrdersByNextToken',
                'GetOrder',
                'ListOrderItems',
                'ListOrderItemsByNextToken',
                'GetServiceStatus',
            ],
            '/' => [
                'RequestReport',
                'GetReportRequestList',
                'GetReportRequestListByNextToken',
                'GetReportRequestCount',
                'CancelReportRequests',
                'GetReportList',
                'GetReportListByNextToken',
                'GetReportCount',
                'GetReport',
                'ManageReportSchedule',
                'GetReportScheduleList',
                'GetReportScheduleListByNextToken',
                'GetReportScheduleCount',
                'UpdateReportAcknowledgements',
                'SubmitFeed',
                'GetFeedSubmissionList',
                'GetFeedSubmissionListByNextToken',
                'GetFeedSubmissionCount',
                'CancelFeedSubmissions',
                'GetFeedSubmissionResult',
            ]
        ]
    ]
];
