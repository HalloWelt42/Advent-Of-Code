<?php

namespace aoc\advent_of_code\y2022\day_02\solve_human_readable;

use SplFileObject;

/**
 * https://adventofcode.com/2022/day/2
 *
 */
class RockPaperScissors
{

    public function __destruct()
    {

        // input
        $file_input = new SplFileObject(__DIR__ . '/../input.txt');

        $sum_a = $sum_b = 0;

        while (($voting_data = $file_input->fgets())) {

            $voting_decoder = new VotingInputDecoder($voting_data);

            // read votes
            $vote_item_elf = $this->itemEncoder($voting_decoder->elf);
            $vote_item_you = $this->itemEncoder($voting_decoder->you);


            // games under rule 1!
            $game_result            = $this->getOwnGameResult($vote_item_you, $vote_item_elf);
            $points_for_game_result = $this->pointValueFromGameResult($game_result);
            $points_for_item        = $this->pointValueFromItem($vote_item_you);

            // add points
            $sum_a += $points_for_game_result + $points_for_item;


            // games under rule 2
            $predefined_result      = $this->getPredefinedResultEncoder($voting_decoder->you);
            $vote_item_you          = $this->getRightItem($predefined_result, $vote_item_elf);
            $points_for_item        = $this->pointValueFromItem($vote_item_you);
            $points_for_game_result = $this->pointValueFromGameResult($predefined_result);

            // add points
            $sum_b += $points_for_game_result + $points_for_item;

        }

        // Ausgabe Teil 1 / 13675
        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2 / 14184
        print_r($sum_b);
        print_r(PHP_EOL);

    }


    /**
     * @param ItemsSelection $item
     * @return int
     */
    private function pointValueFromItem(ItemsSelection $item): int
    {
        return match ($item) {
            ItemsSelection::Rock => 1,
            ItemsSelection::Paper => 2,
            ItemsSelection::Scissors => 3
        };
    }


    /**
     * @param GameResult $result
     * @return int
     */
    private function pointValueFromGameResult(GameResult $result): int
    {
        return match ($result) {
            GameResult::won => 6,
            GameResult::draw => 3,
            GameResult::lose => 0
        };
    }


    /**
     * translate code in item-enum-Objects
     *
     * @param string $type player A or B
     * @return ItemsSelection
     */
    private function itemEncoder(string $type): ItemsSelection
    {
        return match ($type) {
            'A', 'X' => ItemsSelection::Rock,
            'B', 'Y' => ItemsSelection::Paper,
            'C', 'Z' => ItemsSelection::Scissors
        };
    }


    /**
     * @param string $type Chosen strategy input string ('X' || 'Y' || 'Z')
     * @return GameResult
     */
    private function getPredefinedResultEncoder(string $type): GameResult
    {
        return match ($type) {
            'X' => GameResult::lose,
            'Y' => GameResult::draw,
            'Z' => GameResult::won
        };
    }


    /**
     * @param GameResult $my_strategy exacted result
     * @param ItemsSelection $elf_selection what the elf has chosen
     * @return ItemsSelection
     */
    private function getRightItem(GameResult $my_strategy, ItemsSelection $elf_selection): ItemsSelection
    {
        $my_selection = null;

        foreach (ItemsSelection::cases() as $option_selected) {
            $my_result = $this->getOwnGameResult($option_selected, $elf_selection);
            if ($my_result === $my_strategy) {
                $my_selection = $option_selected;
                break;
            }
        }

        return $my_selection;
    }


    /**
     * Determines whether the own player wins
     *
     * @param ItemsSelection $own_player
     * @param ItemsSelection $opponent_player
     * @return GameResult
     */
    private function getOwnGameResult(ItemsSelection $own_player, ItemsSelection $opponent_player): GameResult
    {
        // cases
        return match (true) {

            $own_player === ItemsSelection::Rock && $opponent_player === ItemsSelection::Paper,
                $own_player === ItemsSelection::Paper && $opponent_player === ItemsSelection::Scissors,
                $own_player === ItemsSelection::Scissors && $opponent_player === ItemsSelection::Rock
            => GameResult::lose,

            $own_player === $opponent_player
            => GameResult::draw,

            $own_player === ItemsSelection::Rock && $opponent_player === ItemsSelection::Scissors,
                $own_player === ItemsSelection::Paper && $opponent_player === ItemsSelection::Rock,
                $own_player === ItemsSelection::Scissors && $opponent_player === ItemsSelection::Paper
            => GameResult::won

        };
    }

}