<?php

return [
    'routes' => [
        'main' => [
            'mautic_campaignevent_action'  => [
                'path'       => '/campaigns/events/{objectAction}/{objectId}',
                'controller' => 'Mautic\CampaignBundle\Controller\EventController::executeAction',
            ],
            'mautic_campaignsource_action' => [
                'path'       => '/campaigns/sources/{objectAction}/{objectId}',
                'controller' => 'Mautic\CampaignBundle\Controller\SourceController::executeAction',
            ],
            'mautic_campaign_index'        => [
                'path'       => '/campaigns/{page}',
                'controller' => 'Mautic\CampaignBundle\Controller\CampaignController::indexAction',
            ],
            'mautic_campaign_action'       => [
                'path'       => '/campaigns/{objectAction}/{objectId}',
                'controller' => 'Mautic\CampaignBundle\Controller\CampaignController::executeAction',
            ],
            'mautic_campaign_contacts'     => [
                'path'       => '/campaigns/view/{objectId}/contact/{page}',
                'controller' => 'Mautic\CampaignBundle\Controller\CampaignController::contactsAction',
            ],
            'mautic_campaign_preview'      => [
                'path'       => '/campaign/preview/{objectId}',
                'controller' => 'Mautic\EmailBundle\Controller\PublicController::previewAction',
            ],
        ],
        'api'  => [
            'mautic_api_campaignsstandard'            => [
                'standard_entity' => true,
                'name'            => 'campaigns',
                'path'            => '/campaigns',
                'controller'      => 'Mautic\CampaignBundle\Controller\Api\CampaignApiController',
            ],
            'mautic_api_campaigneventsstandard'       => [
                'standard_entity'     => true,
                'supported_endpoints' => [
                    'getone',
                    'getall',
                ],
                'name'                => 'events',
                'path'                => '/campaigns/events',
                'controller'          => 'Mautic\CampaignBundle\Controller\Api\EventApiController',
            ],
            'mautic_api_campaigns_events_contact'     => [
                'path'       => '/campaigns/events/contact/{contactId}',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\EventLogApiController::getContactEventsAction',
                'method'     => 'GET',
            ],
            'mautic_api_campaigns_edit_contact_event' => [
                'path'       => '/campaigns/events/{eventId}/contact/{contactId}/edit',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\EventLogApiController::editContactEventAction',
                'method'     => 'PUT',
            ],
            'mautic_api_campaigns_batchedit_events'   => [
                'path'       => '/campaigns/events/batch/edit',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\EventLogApiController::editEventsAction',
                'method'     => 'PUT',
            ],
            'mautic_api_campaign_contact_events'      => [
                'path'       => '/campaigns/{campaignId}/events/contact/{contactId}',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\EventLogApiController::getContactEventsAction',
                'method'     => 'GET',
            ],
            'mautic_api_campaigngetcontacts'          => [
                'path'       => '/campaigns/{id}/contacts',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\CampaignApiController::getContactsAction',
            ],
            'mautic_api_campaignaddcontact'           => [
                'path'       => '/campaigns/{id}/contact/{leadId}/add',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\CampaignApiController::addLeadAction',
                'method'     => 'POST',
            ],
            'mautic_api_campaignremovecontact'        => [
                'path'       => '/campaigns/{id}/contact/{leadId}/remove',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\CampaignApiController::removeLeadAction',
                'method'     => 'POST',
            ],
            'mautic_api_contact_clone_campaign' => [
                'path'       => '/campaigns/clone/{campaignId}',
                'controller' => 'Mautic\CampaignBundle\Controller\Api\CampaignApiController::cloneCampaignAction',
                'method'     => 'POST',
            ],
        ],
    ],

    'menu' => [
        'main' => [
            'mautic.campaign.menu.index' => [
                'iconClass' => 'fa-clock-o',
                'route'     => 'mautic_campaign_index',
                'access'    => 'campaign:campaigns:view',
                'priority'  => 50,
            ],
        ],
    ],

    'categories' => [
        'campaign' => null,
    ],

    'services' => [
        'events' => [
            'mautic.campaign.subscriber'                => [
                'class'     => \Mautic\CampaignBundle\EventListener\CampaignSubscriber::class,
                'arguments' => [
                    'mautic.helper.ip_lookup',
                    'mautic.core.model.auditlog',
                    'mautic.campaign.service.campaign',
                    'mautic.core.service.flashbag',
                ],
            ],
            'mautic.campaign.leadbundle.subscriber'     => [
                'class'     => \Mautic\CampaignBundle\EventListener\LeadSubscriber::class,
                'arguments' => [
                    'mautic.campaign.event_collector',
                    'translator',
                    'doctrine.orm.entity_manager',
                    'router',
                ],
            ],
            'mautic.campaign.calendarbundle.subscriber' => [
                'class'     => \Mautic\CampaignBundle\EventListener\CalendarSubscriber::class,
                'arguments' => [
                    'doctrine.dbal.default_connection',
                    'translator',
                    'router',
                ],
            ],
            'mautic.campaign.pointbundle.subscriber'    => [
                'class' => \Mautic\CampaignBundle\EventListener\PointSubscriber::class,
            ],
            'mautic.campaign.search.subscriber'         => [
                'class'     => \Mautic\CampaignBundle\EventListener\SearchSubscriber::class,
                'arguments' => [
                    'mautic.campaign.model.campaign',
                    'mautic.security',
                    'mautic.helper.templating',
                ],
            ],
            'mautic.campaign.dashboard.subscriber'      => [
                'class'     => \Mautic\CampaignBundle\EventListener\DashboardSubscriber::class,
                'arguments' => [
                    'mautic.campaign.model.campaign',
                    'mautic.campaign.model.event',
                ],
            ],
            'mautic.campaignconfigbundle.subscriber'    => [
                'class' => \Mautic\CampaignBundle\EventListener\ConfigSubscriber::class,
            ],
            'mautic.campaign.stats.subscriber'          => [
                'class'     => \Mautic\CampaignBundle\EventListener\StatsSubscriber::class,
                'arguments' => [
                    'mautic.security',
                    'doctrine.orm.entity_manager',
                ],
            ],
            'mautic.campaign.report.subscriber'         => [
                'class'     => \Mautic\CampaignBundle\EventListener\ReportSubscriber::class,
                'arguments' => [
                    'mautic.lead.model.company_report_data',
                ],
            ],
            'mautic.campaign.action.change_membership.subscriber' => [
                'class'     => \Mautic\CampaignBundle\EventListener\CampaignActionChangeMembershipSubscriber::class,
                'arguments' => [
                    'mautic.campaign.membership.manager',
                    'mautic.campaign.model.campaign',
                ],
            ],
            'mautic.campaign.action.jump_to_event.subscriber' => [
                'class'     => \Mautic\CampaignBundle\EventListener\CampaignActionJumpToEventSubscriber::class,
                'arguments' => [
                    'mautic.campaign.repository.event',
                    'mautic.campaign.event_executioner',
                    'translator',
                    'mautic.campaign.repository.lead',
                ],
            ],
        ],
        'forms'        => [
            'mautic.campaign.type.form'                 => [
                'class'     => 'Mautic\CampaignBundle\Form\Type\CampaignType',
                'arguments' => [
                    'mautic.security',
                    'translator',
                ],
            ],
            'mautic.campaignrange.type.action'          => [
                'class' => 'Mautic\CampaignBundle\Form\Type\EventType',
            ],
            'mautic.campaign.type.campaignlist'         => [
                'class'     => 'Mautic\CampaignBundle\Form\Type\CampaignListType',
                'arguments' => [
                    'mautic.campaign.model.campaign',
                    'translator',
                    'mautic.security',
                ],
            ],
            'mautic.campaign.type.trigger.leadchange'   => [
                'class' => 'Mautic\CampaignBundle\Form\Type\CampaignEventLeadChangeType',
            ],
            'mautic.campaign.type.action.addremovelead' => [
                'class' => 'Mautic\CampaignBundle\Form\Type\CampaignEventAddRemoveLeadType',
            ],
            'mautic.campaign.type.action.jump_to_event' => [
                'class' => \Mautic\CampaignBundle\Form\Type\CampaignEventJumpToEventType::class,
            ],
            'mautic.campaign.type.canvassettings'       => [
                'class' => 'Mautic\CampaignBundle\Form\Type\EventCanvasSettingsType',
            ],
            'mautic.campaign.type.leadsource'           => [
                'class'     => 'Mautic\CampaignBundle\Form\Type\CampaignLeadSourceType',
                'arguments' => 'mautic.factory',
            ],
            'mautic.form.type.campaignconfig'           => [
                'class'     => 'Mautic\CampaignBundle\Form\Type\ConfigType',
                'arguments' => 'translator',
            ],
        ],
        'models' => [
            'mautic.campaign.model.campaign' => [
                'class'     => \Mautic\CampaignBundle\Model\CampaignModel::class,
                'arguments' => [
                    'mautic.lead.model.list',
                    'mautic.form.model.form',
                    'mautic.campaign.event_collector',
                    'mautic.campaign.membership.builder',
                    'mautic.tracker.contact',
                ],
            ],
            'mautic.campaign.model.event'     => [
                'class'     => \Mautic\CampaignBundle\Model\EventModel::class,
                'arguments' => [
                    'mautic.user.model.user',
                    'mautic.core.model.notification',
                    'mautic.campaign.model.campaign',
                    'mautic.lead.model.lead',
                    'mautic.helper.ip_lookup',
                    'mautic.campaign.executioner.realtime',
                    'mautic.campaign.executioner.kickoff',
                    'mautic.campaign.executioner.scheduled',
                    'mautic.campaign.executioner.inactive',
                    'mautic.campaign.event_executioner',
                    'mautic.campaign.event_collector',
                    'mautic.campaign.dispatcher.action',
                    'mautic.campaign.dispatcher.condition',
                    'mautic.campaign.dispatcher.decision',
                    'mautic.campaign.repository.lead_event_log',
                ],
            ],
            'mautic.campaign.model.event_log' => [
                'class'     => \Mautic\CampaignBundle\Model\EventLogModel::class,
                'arguments' => [
                    'mautic.campaign.model.event',
                    'mautic.campaign.model.campaign',
                    'mautic.helper.ip_lookup',
                    'mautic.campaign.scheduler',
                ],
            ],
            'mautic.campaign.model.summary' => [
                'class'     => \Mautic\CampaignBundle\Model\SummaryModel::class,
                'arguments' => [
                    'mautic.campaign.repository.lead_event_log',
                ],
            ],
        ],
        'repositories' => [
            'mautic.campaign.repository.campaign' => [
                'class'     => Doctrine\ORM\EntityRepository::class,
                'factory'   => ['@doctrine.orm.entity_manager', 'getRepository'],
                'arguments' => [
                    \Mautic\CampaignBundle\Entity\Campaign::class,
                ],
            ],
            'mautic.campaign.repository.lead' => [
                'class'     => Doctrine\ORM\EntityRepository::class,
                'factory'   => ['@doctrine.orm.entity_manager', 'getRepository'],
                'arguments' => [
                    \Mautic\CampaignBundle\Entity\Lead::class,
                ],
            ],
            'mautic.campaign.repository.event' => [
                'class'     => Doctrine\ORM\EntityRepository::class,
                'factory'   => ['@doctrine.orm.entity_manager', 'getRepository'],
                'arguments' => [
                    \Mautic\CampaignBundle\Entity\Event::class,
                ],
            ],
            'mautic.campaign.repository.lead_event_log' => [
                'class'     => Doctrine\ORM\EntityRepository::class,
                'factory'   => ['@doctrine.orm.entity_manager', 'getRepository'],
                'arguments' => [
                    \Mautic\CampaignBundle\Entity\LeadEventLog::class,
                ],
            ],
            'mautic.campaign.repository.summary' => [
                'class'     => Doctrine\ORM\EntityRepository::class,
                'factory'   => ['@doctrine.orm.entity_manager', 'getRepository'],
                'arguments' => [
                    \Mautic\CampaignBundle\Entity\Summary::class,
                ],
            ],
        ],
        'execution'    => [
            'mautic.campaign.contact_finder.kickoff'  => [
                'class'     => \Mautic\CampaignBundle\Executioner\ContactFinder\KickoffContactFinder::class,
                'arguments' => [
                    'mautic.lead.repository.lead',
                    'mautic.campaign.repository.campaign',
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.campaign.contact_finder.scheduled'  => [
                'class'     => \Mautic\CampaignBundle\Executioner\ContactFinder\ScheduledContactFinder::class,
                'arguments' => [
                    'mautic.lead.repository.lead',
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.campaign.contact_finder.inactive'     => [
                'class'     => \Mautic\CampaignBundle\Executioner\ContactFinder\InactiveContactFinder::class,
                'arguments' => [
                    'mautic.lead.repository.lead',
                    'mautic.campaign.repository.lead',
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.campaign.dispatcher.action'        => [
                'class'     => \Mautic\CampaignBundle\Executioner\Dispatcher\ActionDispatcher::class,
                'arguments' => [
                    'event_dispatcher',
                    'monolog.logger.mautic',
                    'mautic.campaign.scheduler',
                    'mautic.campaign.helper.notification',
                    'mautic.campaign.legacy_event_dispatcher',
                ],
            ],
            'mautic.campaign.dispatcher.condition'        => [
                'class'     => \Mautic\CampaignBundle\Executioner\Dispatcher\ConditionDispatcher::class,
                'arguments' => [
                    'event_dispatcher',
                ],
            ],
            'mautic.campaign.dispatcher.decision'        => [
                'class'     => \Mautic\CampaignBundle\Executioner\Dispatcher\DecisionDispatcher::class,
                'arguments' => [
                    'event_dispatcher',
                    'mautic.campaign.legacy_event_dispatcher',
                ],
            ],
            'mautic.campaign.event_logger' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Logger\EventLogger::class,
                'arguments' => [
                    'mautic.helper.ip_lookup',
                    'mautic.tracker.contact',
                    'mautic.campaign.repository.lead_event_log',
                    'mautic.campaign.repository.lead',
                    'mautic.campaign.model.summary',
                ],
            ],
            'mautic.campaign.event_collector' => [
                'class'     => \Mautic\CampaignBundle\EventCollector\EventCollector::class,
                'arguments' => [
                    'translator',
                    'event_dispatcher',
                ],
            ],
            'mautic.campaign.scheduler.datetime'      => [
                'class'     => \Mautic\CampaignBundle\Executioner\Scheduler\Mode\DateTime::class,
                'arguments' => [
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.campaign.scheduler.interval'      => [
                'class'     => \Mautic\CampaignBundle\Executioner\Scheduler\Mode\Interval::class,
                'arguments' => [
                    'monolog.logger.mautic',
                    'mautic.helper.core_parameters',
                ],
            ],
            'mautic.campaign.scheduler'               => [
                'class'     => \Mautic\CampaignBundle\Executioner\Scheduler\EventScheduler::class,
                'arguments' => [
                    'monolog.logger.mautic',
                    'mautic.campaign.event_logger',
                    'mautic.campaign.scheduler.interval',
                    'mautic.campaign.scheduler.datetime',
                    'mautic.campaign.event_collector',
                    'event_dispatcher',
                    'mautic.helper.core_parameters',
                ],
            ],
            'mautic.campaign.executioner.action' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Event\ActionExecutioner::class,
                'arguments' => [
                    'mautic.campaign.dispatcher.action',
                    'mautic.campaign.event_logger',
                ],
            ],
            'mautic.campaign.executioner.condition' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Event\ConditionExecutioner::class,
                'arguments' => [
                    'mautic.campaign.dispatcher.condition',
                ],
            ],
            'mautic.campaign.executioner.decision' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Event\DecisionExecutioner::class,
                'arguments' => [
                    'mautic.campaign.event_logger',
                    'mautic.campaign.dispatcher.decision',
                ],
            ],
            'mautic.campaign.event_executioner' => [
                'class'     => \Mautic\CampaignBundle\Executioner\EventExecutioner::class,
                'arguments' => [
                    'mautic.campaign.event_collector',
                    'mautic.campaign.event_logger',
                    'mautic.campaign.executioner.action',
                    'mautic.campaign.executioner.condition',
                    'mautic.campaign.executioner.decision',
                    'monolog.logger.mautic',
                    'mautic.campaign.scheduler',
                    'mautic.campaign.helper.removed_contact_tracker',
                    'mautic.campaign.repository.lead',
                ],
            ],
            'mautic.campaign.executioner.kickoff'     => [
                'class'     => \Mautic\CampaignBundle\Executioner\KickoffExecutioner::class,
                'arguments' => [
                    'monolog.logger.mautic',
                    'mautic.campaign.contact_finder.kickoff',
                    'translator',
                    'mautic.campaign.event_executioner',
                    'mautic.campaign.scheduler',
                ],
            ],
            'mautic.campaign.executioner.scheduled'     => [
                'class'     => \Mautic\CampaignBundle\Executioner\ScheduledExecutioner::class,
                'arguments' => [
                    'mautic.campaign.repository.lead_event_log',
                    'monolog.logger.mautic',
                    'translator',
                    'mautic.campaign.event_executioner',
                    'mautic.campaign.scheduler',
                    'mautic.campaign.contact_finder.scheduled',
                ],
            ],
            'mautic.campaign.executioner.realtime'     => [
                'class'     => \Mautic\CampaignBundle\Executioner\RealTimeExecutioner::class,
                'arguments' => [
                    'monolog.logger.mautic',
                    'mautic.lead.model.lead',
                    'mautic.campaign.repository.event',
                    'mautic.campaign.event_executioner',
                    'mautic.campaign.executioner.decision',
                    'mautic.campaign.event_collector',
                    'mautic.campaign.scheduler',
                    'mautic.tracker.contact',
                    'mautic.campaign.helper.decision',
                ],
            ],
            'mautic.campaign.executioner.inactive'     => [
                'class'     => \Mautic\CampaignBundle\Executioner\InactiveExecutioner::class,
                'arguments' => [
                    'mautic.campaign.contact_finder.inactive',
                    'monolog.logger.mautic',
                    'translator',
                    'mautic.campaign.scheduler',
                    'mautic.campaign.helper.inactivity',
                    'mautic.campaign.event_executioner',
                ],
            ],
            'mautic.campaign.helper.decision' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Helper\DecisionHelper::class,
                'arguments' => [
                    'mautic.campaign.repository.lead',
                ],
            ],
            'mautic.campaign.helper.inactivity' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Helper\InactiveHelper::class,
                'arguments' => [
                    'mautic.campaign.scheduler',
                    'mautic.campaign.contact_finder.inactive',
                    'mautic.campaign.repository.lead_event_log',
                    'mautic.campaign.repository.event',
                    'monolog.logger.mautic',
                    'mautic.campaign.helper.decision',
                ],
            ],
            'mautic.campaign.helper.removed_contact_tracker' => [
                'class' => \Mautic\CampaignBundle\Helper\RemovedContactTracker::class,
            ],
            'mautic.campaign.helper.notification' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Helper\NotificationHelper::class,
                'arguments' => [
                    'mautic.user.model.user',
                    'mautic.core.model.notification',
                    'translator',
                    'router',
                    'mautic.helper.core_parameters',
                ],
            ],
            // @deprecated 2.13.0 for BC support; to be removed in 3.0
            'mautic.campaign.legacy_event_dispatcher' => [
                'class'     => \Mautic\CampaignBundle\Executioner\Dispatcher\LegacyEventDispatcher::class,
                'arguments' => [
                    'event_dispatcher',
                    'mautic.campaign.scheduler',
                    'monolog.logger.mautic',
                    'mautic.campaign.helper.notification',
                    'mautic.factory',
                    'mautic.tracker.contact',
                ],
            ],
        ],
        'membership' => [
            'mautic.campaign.membership.adder' => [
                'class'     => \Mautic\CampaignBundle\Membership\Action\Adder::class,
                'arguments' => [
                    'mautic.campaign.repository.lead',
                    'mautic.campaign.repository.lead_event_log',
                ],
            ],
            'mautic.campaign.membership.remover' => [
                'class'     => \Mautic\CampaignBundle\Membership\Action\Remover::class,
                'arguments' => [
                    'mautic.campaign.repository.lead',
                    'mautic.campaign.repository.lead_event_log',
                    'translator',
                    'mautic.helper.template.date',
                ],
            ],
            'mautic.campaign.membership.event_dispatcher' => [
                'class'     => \Mautic\CampaignBundle\Membership\EventDispatcher::class,
                'arguments' => [
                    'event_dispatcher',
                ],
            ],
            'mautic.campaign.membership.manager' => [
                'class'     => \Mautic\CampaignBundle\Membership\MembershipManager::class,
                'arguments' => [
                    'mautic.campaign.membership.adder',
                    'mautic.campaign.membership.remover',
                    'mautic.campaign.membership.event_dispatcher',
                    'mautic.campaign.repository.lead',
                    'monolog.logger.mautic',
                ],
            ],
            'mautic.campaign.membership.builder' => [
                'class'     => \Mautic\CampaignBundle\Membership\MembershipBuilder::class,
                'arguments' => [
                    'mautic.campaign.membership.manager',
                    'mautic.campaign.repository.lead',
                    'mautic.lead.repository.lead',
                    'translator',
                ],
            ],
        ],
        'commands' => [
            'mautic.campaign.command.trigger' => [
                'class'     => \Mautic\CampaignBundle\Command\TriggerCampaignCommand::class,
                'arguments' => [
                    'mautic.campaign.repository.campaign',
                    'event_dispatcher',
                    'translator',
                    'mautic.campaign.executioner.kickoff',
                    'mautic.campaign.executioner.scheduled',
                    'mautic.campaign.executioner.inactive',
                    'monolog.logger.mautic',
                    'mautic.helper.template.formatter',
                    'mautic.lead.model.list',
                    'mautic.helper.segment.count.cache',
                ],
                'tag' => 'console.command',
            ],
            'mautic.campaign.command.execute' => [
                'class'     => \Mautic\CampaignBundle\Command\ExecuteEventCommand::class,
                'arguments' => [
                    'mautic.campaign.executioner.scheduled',
                    'translator',
                    'mautic.helper.template.formatter',
                ],
                'tag' => 'console.command',
            ],
            'mautic.campaign.command.validate' => [
                'class'     => \Mautic\CampaignBundle\Command\ValidateEventCommand::class,
                'arguments' => [
                    'mautic.campaign.executioner.inactive',
                    'translator',
                    'mautic.helper.template.formatter',
                ],
                'tag' => 'console.command',
            ],
            'mautic.campaign.command.update' => [
                'class'     => \Mautic\CampaignBundle\Command\UpdateLeadCampaignsCommand::class,
                'arguments' => [
                    'mautic.campaign.repository.campaign',
                    'translator',
                    'mautic.campaign.membership.builder',
                    'monolog.logger.mautic',
                    'mautic.helper.template.formatter',
                ],
                'tag' => 'console.command',
            ],
            'mautic.campaign.command.summarize' => [
                'class'     => \Mautic\CampaignBundle\Command\SummarizeCommand::class,
                'arguments' => [
                    'translator',
                    'mautic.campaign.model.summary',
                ],
                'tag' => 'console.command',
            ],
        ],
        'services' => [
            'mautic.campaign.service.campaign'=> [
                'class'     => \Mautic\CampaignBundle\Service\Campaign::class,
                'arguments' => [
                    'mautic.campaign.repository.campaign',
                    'mautic.email.repository.email',
                ],
            ],
        ],
        'fixtures' => [
            'mautic.campaign.fixture.campaign' => [
                'class'    => \Mautic\CampaignBundle\DataFixtures\ORM\CampaignData::class,
                'tag'      => \Doctrine\Bundle\FixturesBundle\DependencyInjection\CompilerPass\FixturesCompilerPass::FIXTURE_TAG,
                'optional' => true,
            ],
        ],
    ],
    'parameters' => [
        'campaign_time_wait_on_event_false' => 'PT1H',
        'campaign_use_summary'              => 0,
        'campaign_by_range'                 => 0,
    ],
];
