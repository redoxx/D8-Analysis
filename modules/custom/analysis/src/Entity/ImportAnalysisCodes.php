<?php

namespace Drupal\analysis\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Import analysis codes entity.
 *
 * @ConfigEntityType(
 *   id = "import_analysis_codes",
 *   label = @Translation("Import analysis codes"),
 *   handlers = {
 *     "list_builder" = "Drupal\analysis\ImportAnalysisCodesListBuilder",
 *     "form" = {
 *       "add" = "Drupal\analysis\Form\ImportAnalysisCodesForm",
 *       "edit" = "Drupal\analysis\Form\ImportAnalysisCodesForm",
 *       "delete" = "Drupal\analysis\Form\ImportAnalysisCodesDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\analysis\ImportAnalysisCodesHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "import_analysis_codes",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/import_analysis_codes/{import_analysis_codes}",
 *     "add-form" = "/admin/structure/import_analysis_codes/add",
 *     "edit-form" = "/admin/structure/import_analysis_codes/{import_analysis_codes}/edit",
 *     "delete-form" = "/admin/structure/import_analysis_codes/{import_analysis_codes}/delete",
 *     "collection" = "/admin/structure/import_analysis_codes"
 *   }
 * )
 */
class ImportAnalysisCodes extends ConfigEntityBase implements ImportAnalysisCodesInterface {

  /**
   * The Import analysis codes ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Import analysis codes label.
   *
   * @var string
   */
  protected $label;

}
