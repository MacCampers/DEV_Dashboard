<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Lang;

class LoiRequirement extends Model {

   protected $table = 'loi_requirements';
   protected $with = ['children'];

   public $timestamps = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function children() {
      return $this->hasMany('App\LoiRequirement', 'parent');
   }

   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   public function recursiveList($inputId, $inputName, $old) {
      $html = '<li>';
      $html .= '<input id="'. $inputId .'-'. $this->id .'" type="checkbox" name="'. $inputName .'" value="'. $this->id .'"'. (in_array($this->id, $old) ? " checked" : "") . ($this->parent ? " class=\"has-parent\"" : "") .' />';

      if( Lang::has('loi_requirements.'. $this->code . '_hint') ) {
         $html .= '<label for="'. $inputId .'-'. $this->id .'" '. ($this->parent ? " class=\"has-parent\"" : "") .'>'. $this->name .'<span class="help icon-help" data-id="'. $this->code .'"></span></label>';
         $html .= '<span class="checkmark"></span>';
         $html .= '<div class="help-popin" data-id="'. $this->code .'">' . trans('loi_requirements.'. $this->code . '_hint') . '</div>';
      } else {
         $html .= '<label for="'. $inputId .'-'. $this->id .'" '. ($this->parent ? " class=\"has-parent\"" : "") .'>'. $this->name .'</label>';
         $html .= '<span class="checkmark"></span>';
      }

      if( count($this->children) > 0 ) {
         $html .= '<ul data-parent="'. $this->id .'">';

         foreach( $this->children as $child ) {
            $html .= $child->recursiveList($inputId, $inputName, $old);
         }

         $html .= '</ul>';
      }

      $html .= '</li>';

      return $html;
   }

   public function isChildOf($LoiRequirement) {
      if( count($LoiRequirement->children) > 0 ) {
         foreach( $LoiRequirement->children as $child ) {
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
      return trans('loi_requirements.'. $this->code);
   }

}
