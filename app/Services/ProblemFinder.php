<?php

namespace Gameap\Services;

use Gameap\Repositories\DedicatedServersRepository;
use Knik\Gameap\GdaemonStatus;

class ProblemFinder
{
    private const REQUIRED_EXTENSIONS = ['gd', 'openssl', 'curl', 'gmp', 'intl', 'json', 'zip', 'mbstring'];

    /** @var GdaemonStatus */
    private $gdaemonStatus;

    /** @var DedicatedServersRepository */
    private $nodeRepository;

    public function __construct(GdaemonStatus $gdaemonStatus, DedicatedServersRepository $nodeRepository)
    {
        $this->gdaemonStatus = $gdaemonStatus;
        $this->nodeRepository = $nodeRepository;
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
        if (!empty($this->findInconnectableNodes())) {
            $problems[] = __('home.problems_list.nodes_is_not_available', [
                'nodes' => implode(', ', $inconnectableNodes),
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
}
