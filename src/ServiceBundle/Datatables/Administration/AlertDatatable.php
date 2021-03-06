<?php

namespace ServiceBundle\Datatables\Administration;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

use ServiceBundle\Entity\Administration\Alert;

/**
 * Class AlertDatatable
 *
 * @package ServiceBundle\Datatables
 */
class AlertDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->ajax->set(array(
          // dont put any route here
        ));

        $this->language->set(array(
            'cdn_language_by_locale' => true
            //'language' => 'de'
        ));

        $this->callbacks->set(array(
            'row_callback' => array(
                'template' => 'datatables/callback.js.twig',
            ),
            'init_complete' => array(
                'template' => 'datatables/init.js.twig',
            )
        ));

        $this->options->set(array(
            'dom' => "<'dt-uikit-header'<'uk-grid'<'uk-width-medium-2-3'l><'uk-width-medium-1-3'f>>><'uk-overflow-container'tr><'dt-uikit-footer'<'uk-grid'<'uk-width-medium-3-10'i><'uk-width-medium-7-10'p>>>",
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(1, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' =>  'uikit',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'classes' => "uk-table uk-table-nowrap table_check",
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
        ));

        $this->columnBuilder
            ->add(null, MultiselectColumn::class, array(
              'class_name' => 'uk-table-middle',
              'actions' => array(
                  array(
                      'route' => 'alert_bulk_delete',
                      'icon' => 'uk-icon-trash',
                      'label' => $this->translator->trans('action.delete'),
                      'attributes' => array(
                          'rel' => 'tooltip',
                          'title' => 'Delete',
                          'class' => 'sg-datatables-alert_datatable-multiselect-action md-btn md-btn-primary md-btn-wave-light md-btn-icon waves-effect waves-button waves-light',
                          'role' => 'button'
                      ),
                      'start_html' => '<div class="dt_colVis_buttons">',
                      'end_html' => '</div>',
                  ),
              )
            ))
            ->add('title', Column::class, array(
                'title' => $this->translator->trans('alert.field.title'),
                'class_name' => 'uk-table-middle'
            ))
            ->add('type', Column::class, array(
                'title' => $this->translator->trans('alert.field.type'),
                'class_name' => 'uk-table-middle'
              ))

            ->add(null, ActionColumn::class, array(
                'title' => $this->translator->trans('sg.datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'alert_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => '&#xE417;',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'alert_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => '&#xE254;',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('sg.datatables.actions.show'),
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return Alert::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'alert_datatable';
    }
}
