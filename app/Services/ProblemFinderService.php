<?php

namespace Gameap\Services;

use Gameap\Repositories\NodeRepository;
use Knik\Gameap\GdaemonStatus;

class ProblemFinderService
{
    private const REQUIRED_EXTENSIONS = [
        'bz2',
        'curl',
        'gd',
        'gmp',
        'intl',
        'json',
        'mbstring',
        'openssl',
        'xml',
        'zip',
    ];

    /** @var array */
    private $writableStorageDirectories = [];

    /** @var GdaemonStatus */
    private $gdaemonStatus;

    /** @var NodeRepository */
    private $nodeRepository;

    public function __construct(GdaemonStatus $gdaemonStatus, NodeRepository $nodeRepository)
    {
        $this->gdaemonStatus = $gdaemonStatus;
        $this->nodeRepository = $nodeRepository;

        $this->writableStorageDirectories = [
            storage_path('app'),
            storage_path('app/certs'),
            storage_path('app/certs/client'),
            storage_path('app/public'),
            storage_path('framework'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
        ];
    }

    public function find(): array
    {
        $problems = [];
        $missedExtensions = $this->findMissedExtensions();
        if (!empty($missedExtensions)) {
            $problems[] = __('home.problems_list.required_extenstions_are_missed', [
                'extensions' => implode(', ', $missedExtensions),
            ]);
        }

        $inconnectableNodes = $this->findInconnectableNodes();
        if (!empty($inconnectableNodes)) {
            $problems[] = __('home.problems_list.nodes_is_not_available', [
                'nodes' => implode(', ', $inconnectableNodes),
            ]);
        }

        $writeless = $this->findInsufficientFilePermissions();
        if (!empty($writeless)) {
            $problems[] = __('home.problems_list.not_writable_directories', [
                'paths' => implode(', ', $writeless),
            ]);
        }

        return $problems;
    }

    private function findMissedExtensions(): array
    {
        $extensions = array_map(function(string $value): string {
            return strtolower($value);
        }, get_loaded_extensions());

        return array_diff(self::REQUIRED_EXTENSIONS, $extensions);
    }

    private function findInconnectableNodes(): array
    {
        $problemNodeNames = [];
        $nodes = $this->nodeRepository->find();

        foreach ($nodes as $node) {
            $this->gdaemonStatus->setConfig($node->gdaemonSettings());

            try {
                $this->gdaemonStatus->connect();
            } catch (\RuntimeException $exception) {
                $problemNodeNames[] = $node->name . "(id={$node->id})";
            }

            $this->gdaemonStatus->disconnect();
        }

        return $problemNodeNames;
    }

    private function findInsufficientFilePermissions(): array
    {
        $problemDirectories = [];

        foreach ($this->writableStorageDirectories as $directory) {
            if (!is_writable($directory)) {
                $problemDirectories[] = $directory;
            }
        }

        return $problemDirectories;
    }
}
