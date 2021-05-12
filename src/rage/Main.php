<?php

namespace rage;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
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
        if($command == "heal"){
            if($sender->hasPermission("use.heal"));
            $this->form($sender);
        }
        return true;
    }

    public function form($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
            switch ($result){

                case 0:
                    $player->setHealth($player->getMaxHealth());
                    $player->sendMessage("Healed to the max");
                    break;

            }
            return false;
        });
        $form->setTitle("Heal Form");
        $form->setContent("this is a form to heal your self!");
        $form->addButton("Heal");
        $form->sendToPlayer($player);
        return $form;
    }
}