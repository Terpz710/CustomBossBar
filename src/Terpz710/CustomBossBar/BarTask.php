<?php

declare(strict_types=1);

namespace Terpz710\CustomBossBar;

use pocketmine\scheduler\Task;
use pocketmine\Server;

use Terpz710\CustomBossBar\Loader;

class BarTask extends Task
{
    /** @var Loader */
    private $plugin;

    public function __construct(Loader $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(): void
    {
        foreach (Server::getInstance()->getWorldManager()->getDefaultWorld()->getPlayers() as $player) {
            $bar = $this->plugin::$bar;
            $bar->setTitle($this->plugin->messages->get("title"));
            $bar->setSubTitle($this->plugin->messages->get("subtitle"));
            $color = $bar->getColorByName($this->plugin->messages->get("color"));
            $bar->setColor($color);
        }
    }
}
