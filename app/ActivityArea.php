<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityArea extends Model {

   protected $table = 'activity_areas';
   protected $with = ['children'];

   public $timestamps = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function children() {
      return $this->hasMany('App\ActivityArea', 'parent');
   }

   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   public function recursiveList($inputId, $inputName, $old) {
      $html = '<li>';
      $html .= '<input id="'. $inputId .'-'. $this->id .'" type="checkbox" name="'. $inputName .'" value="'. $this->id .'"'. (in_array($this->id, $old) ? " checked" : "") . ($this->parent ? " class=\"has-parent\"" : "") .' />';
      $html .= '<label for="'. $inputId .'-'. $this->id .'">'. $this->name .'</label>';
      $html .= '<span class="checkmark"></span>';

      if( count($this->children) > 0 ) {
         $html .= '<span class="toggle-list icon-chevron-right"></span>';
         $html .= '<ul data-parent="'. $this->id .'">';

         foreach( $this->children as $child ) {
            $html .= $child->recursiveList($inputId, $inputName, $old);
         }

         $html .= '</ul>';
      }

      $html .= '</li>';

      return $html;
   }

   public function isChildOf($activityArea) {
      if( count($activityArea->children) > 0 ) {
         foreach( $activityArea->children as $child ) {
            if( $child->id === $this->id ) {
               return true;
            } elseif( $this->isChildOf($child) ) {
               return true;
            }
         }
      }

      return false;
   }

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getNameAttribute() {
      return trans('activity_areas.'. $this->code);
   }

}
