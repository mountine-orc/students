<?php

namespace Tests\StudentBundle\Services;

use Doctrine\ORM\EntityManager;
use StudentBundle\Entity\Student;
use StudentBundle\Services\PathCreator;
use  Doctrine\ORM\AbstractQuery;

class PathCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdatePath()
    {
        //Create Mocks
        $studentMock = $this->getMockBuilder(Student::class)
            ->disableOriginalConstructor()
            ->getMock();

        $queryMock = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(array('iterate'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $emMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();


        //set expectations
        $emMock->expects($this->any())
            ->method('createQuery')
            ->will($this->returnValue($queryMock));

        $queryMock->expects($this->once())
            ->method('iterate')
            ->will($this->returnValue($this->studentIterator($studentMock)));

        $studentMock->expects($this->exactly(60))
            ->method('setPath');

        $emMock->expects($this->exactly(3))
            ->method('clear');

        $emMock->expects($this->exactly(4))
            ->method('flush');

        $PathCreatorService = new PathCreator($emMock);
        $PathCreatorService->updatePath(20);
    }

    function studentIterator($studentMock)
    {
        for ($i = 1; $i <= 60; $i++) {
            yield $i => [0 => $studentMock];
        }
    }
}
