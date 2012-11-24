<h5><i class="icon-fire"></i> <?php echo __("Statistiques des armes par joueurs"); ?></h5>

<?php
$players = array();
$kills = PlayerKillTable::getInstance()->createQuery()->where("match_id = ?", $match->getId())->execute();
foreach ($kills as $kill) {
    @$players[$kill->getKillerId()][$kill->getWeapon()]["k"]++;
    @$players[$kill->getKilledId()][$kill->getWeapon()]["d"]++;
}

$weapons = array("glock", "hkp2000", "deagle", "p250", "tec9", "awp", "m4a1", "ak47", "famas", "galilar", "hegrenade", "inferno", "scar20", "mp7", "bizon", "p90", "mag7", "ump45", "taser", "nova", "mac10", "mp9", "elite", "ssg08");
?>

<table class="table">
    <thead>
        <tr>
            <td rowspan="2"></td>
            <?php foreach ($weapons as $weapon): ?>
                <td style="border-left: 1px solid #DDDDDD; text-align: center; min-width: 50px;" colspan="2"><?php echo image_tag("/images/kills/csgo/" . $weapon . ".png", array("class" => "needTips_S", "title" => $weapon)); ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($weapons as $weapon): ?>
                <td style="border-left: 2px solid #DDDDDD;text-align: center;font-size: 10px; border-right: 1px solid #EEEEEE;">K</td>
                <td style="font-size: 10px; text-align: center;">D</td>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($match->getMap()->getPlayer() as $player): ?>
            <?php if ($player->getTeam() == "other") continue; ?>
            <tr>
                <td style="width: 250px; min-width: 250px;"><a href="<?php echo url_for("player_stats", array("id" => $player->getSteamid())); ?>"><?php echo $player->getPseudo(); ?></a></td>
                <?php foreach ($weapons as $weapon): ?>
                    <td style="text-align: center;border-left: 2px solid #DDDDDD; border-right: 1px solid #EEEEEE;" <?php if (@$players[$player->getId()][$weapon]["k"] * 1 == 0) echo 'class="muted"'; ?>>
                        <?php echo @$players[$player->getId()][$weapon]["k"] * 1; ?>
                    </td>
                    <td style="text-align: center;" <?php if (@$players[$player->getId()][$weapon]["d"] * 1 == 0) echo 'class="muted"'; ?>>
                        <?php echo @$players[$player->getId()][$weapon]["d"] * 1; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h5><i class="icon-info-sign"></i> Aide</h5>
<div class="well">
    <?php echo __("<p>La colonne <b>K</b> représente les kills effectués avec l'arme, la colonne <b>D</b> représente le nombre de fois que le joueur a été tué par l'arme</p>"); ?>		
</div>