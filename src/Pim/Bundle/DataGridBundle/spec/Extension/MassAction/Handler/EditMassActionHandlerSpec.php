<?php

namespace spec\Pim\Bundle\DataGridBundle\Extension\MassAction\Handler;

use Pim\Bundle\DataGridBundle\Extension\MassAction\Event\MassActionEvent;
use Oro\Bundle\DataGridBundle\Datagrid\DatagridInterface;
use PhpSpec\ObjectBehavior;
use Pim\Bundle\DataGridBundle\Datasource\DatasourceInterface;
use Pim\Bundle\DataGridBundle\Datasource\ResultRecord\HydratorInterface;
use Pim\Bundle\DataGridBundle\Extension\MassAction\Actions\Redirect\EditMassAction;
use Pim\Bundle\DataGridBundle\Extension\MassAction\Event\MassActionEvents;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditMassActionHandlerSpec extends ObjectBehavior
{
    function let(HydratorInterface $hydrator, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($hydrator, $eventDispatcher);
    }

    function it_handles_edit_mass_action(
        $eventDispatcher,
        $hydrator,
        DatagridInterface $datagrid,
        DatasourceInterface $datasource,
        EditMassAction $massAction
    ) {
        $objectIds = ['foo', 'bar', 'baz'];

        $eventDispatcher->dispatch(
            MassActionEvents::MASS_EDIT_PRE_HANDLER,
            Argument::type(MassActionEvent::class)
        )->shouldBeCalled();
        $eventDispatcher->dispatch(
            MassActionEvents::MASS_EDIT_POST_HANDLER,
            Argument::type(MassActionEvent::class)
        )->shouldBeCalled();

        $datagrid->getDatasource()->willReturn($datasource);
        $datasource->setHydrator($hydrator)->shouldBeCalled();
        $datasource->getResults()->willReturn($objectIds);

        $this->handle($datagrid, $massAction)->shouldReturn($objectIds);
    }
}
