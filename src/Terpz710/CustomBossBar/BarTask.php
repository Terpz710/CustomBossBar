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
            $messages = $this->plugin->getMessages();
            $bar->setTitle($messages->get("title"));
            $bar->setSubTitle($messages->get("subtitle"));
            $color = $bar->getColorByName($messages->get("color"));
            $bar->setColor($color);
        }
    }
}
