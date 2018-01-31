<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Project;
use App\Strategy;

class AlgorithmController extends Controller {

   /**
   * Run algorithm
   *
   * @return View
   */
   public function run(Project $project, $showLogs = false) {
      $strategies = Strategy::with(['zones', 'activity_areas', 'development_stages'])->where('confirmed', 1)->get();

      $weighting = [
         'investment_zone' => 10,
         'investment_zone_unset' => 5,

         'location' => 30,
         'location_same_country' => 9,

         'development_stage' => 20,
         'development_stage_before' => 7,

         'official_activity_area_1' => 30,
         'official_activity_area_2' => 25,
         'official_activity_area_3' => 20,
         'official_activity_area_4' => 15,
         'privileged_activity_area_1' => 20,
         'privileged_activity_area_2' => 15,
         'privileged_activity_area_3' => 10,
         'privileged_activity_area_4' => 5,

         'search_zones' => 8,
         'search_zones_child' => 5,
         'search_zones_nofocus' => 1,

         'amount_searched_equiteasy' => 40,
         'amount_searched' => 30,
         'amount_searched_equiteasy_margin' => 10,
         'amount_searched_margin' => 10,

         'turnover_equiteasy' => 10,
         'turnover' => 5,
         'turnover_equiteasy_margin' => 3,
         'turnover_margin' => 2,
         'bonus_handover' => 10,

         'mbi' => 5,
         'mbi_null' => 2,

         'ebitda' => 30,
         'ebitda_bonus' => 10,

         'social_impact' => 20,

         'margin' => 20,
      ];

      $logs = '';

      foreach( $strategies as $key => $strategy ) {

         $strategy->score = 0;

         $logs .= '<section>';
         $logs .= '<h3>'. $strategy->name .'</h3>';


         /*
         |--------------------------------------------------------------------------
         | Investment zones
         |--------------------------------------------------------------------------
         */

         $logs .= "<h4>Zone d'investissement</h4>";
         $score = 0;

         if( $strategy->investment_zones->count() > 0 ) {
            $parents = [];

            foreach( $strategy->investment_zones as $investmentZone ) {
               if( $project->location->id === $investmentZone->id || $project->location->isChildOf($investmentZone) ) {
                  $score += $weighting['investment_zone'];
               }
            }

            $logs .= $project->location->name . ' : +' . $score . '<br />';
         } else {
            $logs .= 'Zone d\'investissement indifférente : + '. $weighting['investment_zone_unset'] .' <br />';
            $score += $weighting['investment_zone_unset'];
         }

         // Remove strategy from collection if the company location is not in the strategy's investment zones
         if( $score === 0 ) {
            $strategies->forget($key);

            $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

            continue;
         } else {
            $strategy->score += $score;
         }


         /*
         |--------------------------------------------------------------------------
         | Location
         |--------------------------------------------------------------------------
         */

         $logs .= "<h4>Zone d'implantation</h4>";
         $score = 0;

         if( $strategy->locations->count() > 0 ) {
            $parents = [];

            foreach( $strategy->locations as $location ) {
               if( ($project->location->id === $location->id || $project->location->isChildOf($location)) && $score < $weighting['location'] ) {
                  $score = $weighting['location'];
               } elseif( ($project->location->type === 'region' && $location->type === 'region' && !in_array($location->parent, $parents) && $project->location->parent === $location->parent) && $score < $weighting['location_same_country'] ) {
                  $score = $weighting['location_same_country'];

                  $parents[] = $location->parent;
               }
            }

            $logs .= $project->location->name . ' : +' . $score . '<br />';

            $strategy->score += $score;
         } else {
            $logs .= 'Pas de zone d\'implantation définie : +0<br />';
         }


         /*
         |--------------------------------------------------------------------------
         | Development stage
         |--------------------------------------------------------------------------
         */

         $logs .= "<h4>Stade de développement</h4>";
         $score = 0;

         if( $strategy->development_stages->count() > 0 ) {
            foreach( $strategy->development_stages as $developmentStage ) {

               if( $project->development_stage_id === $developmentStage->id ) {
                  $logs .= $developmentStage->code . ' : +' . $weighting['development_stage'] . '<br />';
                  $score += $weighting['development_stage'];
               } elseif( $project->development_stage_id === 1 && $developmentStage->id === 2 || $project->development_stage_id === 2 && $developmentStage->id === 1 || $project->development_stage_id === 3 && $developmentStage->id === 2 || $project->development_stage_id === 2 && $developmentStage->id === 3 ) {
                  $logs .= $developmentStage->code . ' : +' . $weighting['development_stage_before'] . '<br />';
                  $score += $weighting['development_stage_before'];
               } else {
                  $logs .= $developmentStage->code . ' : +0<br />';
               }

            }

            // Remove strategy from collection if the development stage is not targetted
            if( $score === 0 ) {
               $strategies->forget($key);

               $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

               continue;
            } else {
               $strategy->score += $score;
            }
         } else {
            $logs .= 'Pas de stade de développement ciblé : +0<br />';
         }


         /*
         |--------------------------------------------------------------------------
         | Activity areas
         |--------------------------------------------------------------------------
         */

         $logs .= "<h4>Secteurs d'activité</h4>";
         $score = 0;

         $officialScore = 0;

         $officialCount = $strategy->getActivityAreasCount('official');
         $privilegedCount = $strategy->getActivityAreasCount('privileged');

         $officialWeighting = $weighting['official_activity_area_' . ($officialCount <= 4 && $officialCount > 0 ? $officialCount : 4)];
         $privilegedWeighting = $weighting['privileged_activity_area_' . ($privilegedCount <= 4 && $privilegedCount > 0 ? $privilegedCount : 4)];

         $logs .= '<div style="opacity: .5">';
         $logs .= $officialCount . " secteur(s) officiel(s) : bonus = " . $officialWeighting . "<br />";
         $logs .= $privilegedCount . " secteur(s) privilégié(s) : bonus = " . $privilegedWeighting . "<br />";
         $logs .= '</div>';

         if( $strategy->activity_areas->count() > 0 ) {

            foreach( $project->activity_areas as $projectArea ) {
               // Official activity areas (remove if not targetted)
               if( $strategy->official_activity_areas->count() > 0 ) {
                  foreach( $strategy->official_activity_areas as $strategyArea ) {
                     if( $projectArea->id === $strategyArea->id || $projectArea->isChildOf($strategyArea) || $strategyArea->isChildOf($projectArea) ) {
                        $logs .= $projectArea->name . ' (officiel) : +' . $officialWeighting . '<br />';
                        $score += $officialWeighting;

                        break;
                     }
                  }
               } else {
                  $logs .= $projectArea->name . ' (officiel) : +' . $officialWeighting . '<br />';
                  $score += $officialWeighting;
               }
            }

            // Remove strategy from collection if none of the official activity areas are targetted
            if( $score === 0 ) {
               $strategies->forget($key);

               $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

               continue;
            }

            foreach( $project->activity_areas as $projectArea ) {
               // Privileged activity areas
               if( $strategy->privileged_activity_areas->count() > 0 ) {
                  foreach( $strategy->privileged_activity_areas as $strategyArea ) {
                     if( $projectArea->id === $strategyArea->id || $projectArea->isChildOf($strategyArea) || $strategyArea->isChildOf($projectArea) ) {
                        $logs .= $projectArea->name . ' (privilégié) : +' . $privilegedWeighting . '<br />';
                        $score += $privilegedWeighting;

                        break;
                     }
                  }
               } else {
                  $logs .= $projectArea->name . ' (privilégié) : +' . $privilegedWeighting . '<br />';
                  $score += $privilegedWeighting;
               }
            }

         } else {
            $logs .= 'Pas de focus sectoriel : +' . ($weighting['official_activity_area_4'] + $weighting['privileged_activity_area_4']) . '<br />';
            $score += $weighting['official_activity_area_4'] + $weighting['privileged_activity_area_4'];
         }

         $strategy->score += $score;


         /*
         |--------------------------------------------------------------------------
         | Search zones
         |--------------------------------------------------------------------------
         */
         //
         // $logs .= "<h4>Zones de recherche</h4>";
         // $score = 0;
         //
         // if( count($project->search_zones) > 0 ) {
         //
         //    foreach( $project->search_zones as $projectZone ) {
         //       foreach( $strategy->locations as $strategyLocation ) {
         //          if( $projectZone->id === $strategyLocation->id ) {
         //             $logs .= $projectZone->name . ' : +' . $weighting['search_zones'] . '<br />';
         //             $score += $weighting['search_zones'];
         //          } elseif( $projectZone->isChildOf($strategyLocation) || $strategyLocation->isChildOf($projectZone) ) {
         //             $logs .= $projectZone->name . ' : +' . $weighting['search_zones_child'] . '<br />';
         //             $score += $weighting['search_zones_child'];
         //          }
         //       }
         //    }
         //
         //    // Remove strategy from collection if none of the locations are targetted
         //    if( $score === 0 ) {
         //       $strategies->forget($key);
         //
         //       $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';
         //
         //       continue;
         //    }
         //
         // } else {
         //    $logs .= 'Pas de focus sectoriel : +' . $weighting['search_zones_nofocus'] . '<br />';
         //    $score += $weighting['search_zones_nofocus'];
         // }
         //
         // $strategy->score += $score;


         /*
         |--------------------------------------------------------------------------
         | Fundraising
         |--------------------------------------------------------------------------
         */

         $score = 0;

         if( $project->type === 'fundraising' ) {
            $logs .= '<h4>Levée de fonds</h4>';

            $logs .= 'Montant recherché = '. number_format($project->amount_searched, 0, ',', ' ') .'<br />';

            // Get values and multiply by 1000
            $minEq = $strategy->amount_min_equiteasy ? $strategy->amount_min_equiteasy * 1000 : 0;
            $maxEq = $strategy->amount_max_equiteasy ? $strategy->amount_max_equiteasy * 1000 : INF;
            $min = $strategy->amount_min ? $strategy->amount_min * 1000 : 0;
            $max = $strategy->amount_max ? $strategy->amount_max * 1000 : INF;

            $sameValues = ($minEq === $min && $maxEq === $max);

            // Check if values are set
            $hasEquiteasy = true;
            $hasOfficial = true;

            if( $minEq === 0 && $maxEq === INF ) {
               $hasEquiteasy = false;
            }
            if( $min === 0 && $max === INF ) {
               $hasOfficial = false;
            }

            // If there is no official value but one set by Equiteasy, duplicate Equiteasy value in official value
            if( $hasEquiteasy && !$hasOfficial ) {
               $min = $minEq;
               $max = $maxEq;
            }

            if( $hasEquiteasy && !$sameValues && $project->amount_searched >= $minEq && $project->amount_searched <= $maxEq ) {
               $logs .= 'Montant compris entre '. number_format($minEq, 0, ',', ' ') .' et '. number_format($maxEq, 0, ',', ' ') .' (Equiteasy) : +' . $weighting['amount_searched_equiteasy'] . '<br />';
               $score += $weighting['amount_searched_equiteasy'];
            } elseif( $project->amount_searched >= $min && $project->amount_searched <= $max ) {
               $logs .= 'Montant compris entre '. number_format($min, 0, ',', ' ') .' et '. number_format($max, 0, ',', ' ') .' : +' . $weighting['amount_searched'] . '<br />';
               $score += $weighting['amount_searched'];
            } else {
               // Apply margin
               $minEq -= $minEq * $weighting['margin'] / 100;
               $maxEq += $maxEq * $weighting['margin'] / 100;
               $min -= $min * $weighting['margin'] / 100;
               $max += $max * $weighting['margin'] / 100;

               if( $hasEquiteasy && !$sameValues && $project->amount_searched >= $minEq && $project->amount_searched <= $maxEq ) {
                  $logs .= 'Montant compris entre '. number_format($minEq, 0, ',', ' ') .' et '. number_format($maxEq, 0, ',', ' ') .' (Equiteasy ±' . $weighting['margin'] . '%) : +' . $weighting['amount_searched_equiteasy_margin'] . '<br />';
                  $score += $weighting['amount_searched_equiteasy_margin'];
               } elseif( $project->amount_searched >= $min && $project->amount_searched <= $max ) {
                  $logs .= 'Montant compris entre '. number_format($min, 0, ',', ' ') .' et '. number_format($max, 0, ',', ' ') .' (±' . $weighting['margin'] . '%): +' . $weighting['amount_searched_margin'] . '<br />';
                  $score += $weighting['amount_searched_margin'];
               }
            }

            // Remove strategy from collection if the searched amount is not matching the strategy
            if( $score === 0 ) {
               $strategies->forget($key);

               $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

               continue;
            } else {
               $strategy->score += $score;
            }
         }


         /*
         |--------------------------------------------------------------------------
         | Turnover
         |--------------------------------------------------------------------------
         */

         $score = 0;

         $logs .= "<h4>Chiffre d'affaires</h4>";

         // Get values and multiply by 1000
         $minEq = $strategy->revenues_min_equiteasy ? $strategy->revenues_min_equiteasy * 1000 : 0;
         $maxEq = $strategy->revenues_max_equiteasy ? $strategy->revenues_max_equiteasy * 1000 : INF;
         $min = $strategy->revenues_min ? $strategy->revenues_min * 1000 : 0;
         $max = $strategy->revenues_max ? $strategy->revenues_max * 1000 : INF;

         $sameValues = ($minEq === $min && $maxEq === $max);

         // Check if values are set
         $hasEquiteasy = true;
         $hasOfficial = true;

         if( $minEq === 0 && $maxEq === INF ) {
            $hasEquiteasy = false;
         }
         if( $min === 0 && $max === INF ) {
            $hasOfficial = false;
         }

         // If there is no official value but one set by Equiteasy, duplicate Equiteasy value in official value
         if( $hasEquiteasy && !$hasOfficial ) {
            $min = $minEq;
            $max = $maxEq;
         }

         if( $hasEquiteasy && !$sameValues && $project->turnover_m_1 >= $minEq && $project->turnover_m_1 <= $maxEq ) {
            $logs .= 'CA n-1 ('. number_format($project->turnover_m_1, 0, ',', ' ') .') entre '. number_format($minEq, 0, ',', ' ') .' et '. number_format($maxEq, 0, ',', ' ') .' (Equiteasy) : +' . $weighting['turnover_equiteasy'] . '<br />';
            $score += $weighting['turnover_equiteasy'];
         } elseif( $project->turnover_m_1 >= $min && $project->turnover_m_1 <= $max ) {
            $logs .= 'CA n-1 ('. number_format($project->turnover_m_1, 0, ',', ' ') .') entre '. number_format($min, 0, ',', ' ') .' et '. number_format($max, 0, ',', ' ') .' : +' . $weighting['turnover'] . '<br />';
            $score += $weighting['turnover'];
         } else {
            // Apply margin
            $minEq -= $minEq * $weighting['margin'] / 100;
            $maxEq += $maxEq * $weighting['margin'] / 100;
            $min -= $min * $weighting['margin'] / 100;
            $max += $max * $weighting['margin'] / 100;

            if( $hasEquiteasy && !$sameValues && $project->turnover_m_1 >= $minEq && $project->turnover_m_1 <= $maxEq ) {
               $logs .= 'CA n-1 ('. number_format($project->turnover_m_1, 0, ',', ' ') .') entre '. number_format($minEq, 0, ',', ' ') .' et '. number_format($maxEq, 0, ',', ' ') .' (Equiteasy ±' . $weighting['margin'] . '%) : +' . $weighting['turnover_equiteasy_margin'] . '<br />';
               $score += $weighting['turnover_equiteasy_margin'];
            } elseif( $project->turnover_m_1 >= $min && $project->turnover_m_1 <= $max ) {
               $logs .= 'CA n-1 ('. number_format($project->turnover_m_1, 0, ',', ' ') .') entre '. number_format($min, 0, ',', ' ') .' et '. number_format($max, 0, ',', ' ') .' (±' . $weighting['margin'] . '%) : +' . $weighting['turnover_margin'] . '<br />';
               $score += $weighting['turnover_margin'];
            }
         }

         // Remove strategy from collection if the turnover is not matching the strategy and project type is handover
         if( $project->type === 'handover' ) {
            if( $score === 0 ) {
               $strategies->forget($key);

               $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

               continue;
            } else {
               $logs .= 'Bonus transmission : +' . $weighting['bonus_handover'] . '<br />';
               $score += $weighting['bonus_handover'];
            }
         } else {
            $logs .= 'CA n-1 ('. number_format($project->turnover_m_1, 0, ',', ' ') .') non concordant : +0<br />';
         }

         $strategy->score += $score;


         /*
         |--------------------------------------------------------------------------
         | MBI
         |--------------------------------------------------------------------------
         */

         $score = 0;

         $logs .= "<h4>MBI</h4>";

         if( $strategy->mbi !== null ) {

            // Remove strategy from collection if MBI is set to true in the project and no in the strategy
            if( $project->mbi && !$strategy->mbi ) {
               $strategies->forget($key);

               $logs .= 'MBI non concordant.<br />';
               $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

               continue;
            } elseif( $project->mbi && $strategy->mbi ) {
               $logs .= 'MBI : +' . $weighting['mbi'] . '<br />';
               $score = $weighting['mbi'];
            } elseif( !$project->mbi ) {
               $logs .= 'Pas de recherche de repreneur.<br />';
            }

         } else {
            $logs .= 'MBI indifférent : +' . $weighting['mbi_null'] . '<br />';
            $score = $weighting['mbi_null'];
         }

         $strategy->score += $score;


         /*
         |--------------------------------------------------------------------------
         | Profitability (EBE)
         |--------------------------------------------------------------------------
         */

         $score = 0;

         if( $strategy->profitable !== null ) {

            $logs .= "<h4>Rentabilité</h4>";

            if( $strategy->profitable ) {
               if( $project->ebitda_m_1 > $project->turnover_m_1*15/100 ) {
                  $logs .= 'EBE n-1 > 15% du CA : +' . $weighting['ebitda_bonus'] . '<br />';
                  $score += $weighting['ebitda_bonus'];
               } elseif( $project->ebitda_m_1 > $project->turnover_m_1*2/100 ) {
                  $logs .= 'EBE n-1 > 2% du CA : +' . $weighting['ebitda'] . '<br />';
                  $score += $weighting['ebitda'];
               } else {
                  $logs .= 'EBE < 2% du CA : +0<br />';
               }
            } else {
               if( $project->ebitda_m_1 <= $project->turnover_m_1*2/100 ) {
                  $logs .= 'EBE n-1 < 2% du CA : +' . $weighting['ebitda'] . '<br />';
                  $score += $weighting['ebitda'];
               } else {
                  $logs .= 'EBE > 2% du CA : +0<br />';
               }
            }

            $strategy->score += $score;

         }


         /*
         |--------------------------------------------------------------------------
         | Social impact
         |--------------------------------------------------------------------------
         */

         $score = 0;

         if( $strategy->social_impact !== null ) {

            $logs .= "<h4>Impact social et environnemental</h4>";

            if( $project->social_impact ) {
               if( $strategy->social_impact ) {
                  $logs .= 'Concordant : +'. $weighting['social_impact'] .'<br />';
                  $score += $weighting['social_impact'];
               } else {
                  $logs .= 'Pas de correspondance : +0<br />';
               }
            } else {
               if( $strategy->social_impact ) {
                  $strategies->forget($key);

                  $logs .= 'Non concordant.<br />';
                  $logs .= '<span style="color: red;">Pas de correspondance : suppression</span></section>';

                  continue;
               } else {
                  $logs .= 'Pas de correspondance : +0<br />';
               }
            }

            $strategy->score += $score;

         }


         /*
         |--------------------------------------------------------------------------
         | End logs
         |--------------------------------------------------------------------------
         */
         $logs .= '<div class="total-score">Score total : '. $strategy->score .'</div>';

         $logs .= '</section>';

      }

      $results = $strategies->sortByDesc('score')->values();

      if( $showLogs ) {
         return ['strategies' => $results, 'logs' => $logs];
      }

      return $results;
   }

}
