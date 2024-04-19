<?php

declare(strict_types=1);

namespace Terpz710\CustomBossBar;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;

use Terpz710\CustomBossBar\BarTask;

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
        self::$bar = (new BossBar())->setPercentage(intval($this->messages->get("percentage")));
        $this->getScheduler()->scheduleRepeatingTask(new BarTask($this), 20);
    }

    public function onJoin(PlayerJoinEvent $ev)
    {
        self::$bar->addPlayer($ev->getPlayer());
    }
}
