<?php

namespace rage;

use jojoe77777\FormAPI\SimpleForm;
use onebone\EconomyAPI;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;


class Main extends PluginBase implements Listener{


    public function onEnable()
    {
        $this->getLogger()->info("Rage plugin Enabled");
    }

    public function onDisable()
    {
        $this->getLogger()->info("Rage plugin disabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $command = strtolower($command);
        if($command == "rankup"){
        	if($sender instanceof Player){
				$this->form($sender);
			} else {
        		$sender->sendMessage("hey you cant do this from console!");
			}

        }
        return true;
    }

    public function form($player){
        $api = $this->getServer()->getPluginManager()->getPlugins("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
            switch ($result){

                case 0:

                	EconomyAPI::getInstance()->removeMoney($player, 50);
                	$player->sendMessage("Rank Has been Upgraded!");
                	$player->teleport(new Vector3(10, 60, 50));
                    break;
				case 1:

					EconomyAPI::getInstance()->addMoney($player, 100);
					$player->sendMessage("You have now gained 100 dollars!");

            }
            return false;
        });
        $form->setTitle("RankUp Form");
        $form->setContent("this is a form to rank up!");
        $form->addButton("Mine A (Price $50)");
	$form->addButton("Get 100 dollars!");
        $form->sendToPlayer($player);
        return $form;
    }
}
