<?php

namespace Cissee\Webtrees\Hook\HookInterfaces;

use Cissee\WebtreesExt\FactPlaceAdditions;
use Cissee\WebtreesExt\FormatPlaceAdditions;
use Fisharebest\Webtrees\Fact;
use Fisharebest\Webtrees\Individual;
use Fisharebest\Webtrees\Tree;
use Vesta\Model\GenericViewElement;
use Vesta\Model\PlaceStructure;

/**
 * Interface for modules which intend to hook into 'Facts and events' tab
 */
interface IndividualFactsTabExtenderInterface {

  public function setFactsTabUIElementOrder(int $order): void;

  public function getFactsTabUIElementOrder(): int;

  public function defaultFactsTabUIElementOrder(): int;

  /**
   * if ajax-modal-vesta placeholder is required, return the respective select2 initializer javascript snippet here!
   * the modal placeholder itself is added by the vesta_personal_facts module itself if required.
   * 
   * @return string|null
   */
  public function hFactsTabRequiresModalVesta(Tree $tree): ?string;
  
  /**
   *
   * @param Individual $person
   * @return array (array of Fact) additional facts (e.g. further historical facts, research suggestions or other 'virtual' facts)
   */
  public function hFactsTabGetAdditionalFacts(Individual $person);

  /**
   * css classes for styling of facts via fact id (intended for additional facts) 
   *  
   * @return array (key: fact id, value: css class)
   */
  public function hFactsTabGetStyleadds();

  /**
   *
   * @param Individual $person
   * @return GenericViewElement with html to display before the entire tab, and script
   */
  public function hFactsTabGetOutputBeforeTab(Individual $person);

  /**
   *
   * @param Individual $person
   * @return GenericViewElement with html to display after the entire tab, and script
   */
  public function hFactsTabGetOutputAfterTab(Individual $person);

  /**
   *
   * @param Individual $person
   * @return GenericViewElement with html to display in the description box, and script
   */
  public function hFactsTabGetOutputInDBox(Individual $person);

  /**
   *
   * @param Individual $person
   * @return GenericViewElement with html to display after the description box, and script
   */
  public function hFactsTabGetOutputAfterDBox(Individual $person);

  /**
   *
   * @param $place
   *
   * @return FormatPlaceAdditions
   */
  //deprecated
  public function hFactsTabGetFormatPlaceAdditions(PlaceStructure $place);
  
  public function factPlaceAdditions(PlaceStructure $place): ?FactPlaceAdditions;

  /**
   * first hook subscriber to return non-empty or null wins! 
   * 
   * @param Fact $event
   * @param Individual $person
   * @param Individual $associate
   * @param string $relationship_prefix decorator, should be kept unless entire output is hidden
   * @param string $relationship_name may be used or replaced with soething more specific
   * @param string $relationship_suffix decorator, should be kept unless entire output is hidden
   * @param boolean $inverse indicates that relationship will be displayed for 'inverse' ASSO rel
   * 
   * @return GenericViewElement|null html or null (indicating nothing should be displayed, not even the default fallback)
   */
  public function hFactsTabGetOutputForAssoRel(
          Fact $event,
          Individual $person,
          Individual $associate,
          $relationship_prefix,
          $relationship_name,
          $relationship_suffix,
          $inverse);
  
  /**
   * called even if fact itself isn't editable!
   * 
   * @param Fact $event
   * @return GenericViewElement
   */
  public function hFactsTabGetAdditionalEditControls(
          Fact $event): GenericViewElement;
}
