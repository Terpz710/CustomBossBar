<?php

declare(strict_types=1);

namespace Terpz710\CustomBossBar;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;

use xenialdan\apibossbar\BossBar;

class Loader extends PluginBase implements Listener
{

    /** @var BossBar */
    public static $bar;
    /** @var Config */
    private $messages;

    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->messages = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $messages = $this->messages;
        self::$bar = (new BossBar())->setPercentage(intval($messages->get("percentage")));
        $this->getScheduler()->scheduleRepeatingTask(new class($messages) extends Task
        {
            private $messages;

            public function __construct(Config $messages)
            {
                $this->messages = $messages;
            }

            public function onRun(): void
            {
                foreach (Server::getInstance()->getWorldManager()->getDefaultWorld()->getPlayers() as $player) {
                    Loader::$bar->setTitle($this->messages->get("title"));
                    Loader::$bar->setSubTitle($this->messages->get("subtitle"));
                    $color = Loader::$bar->getColorByName($this->messages->get("color"));
                    Loader::$bar->setColor($color);
                }
            }
        }, 20);
    }

    public function onJoin(PlayerJoinEvent $ev)
    {
        self::$bar->addPlayer($ev->getPlayer());
    }
}