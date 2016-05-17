<?php
namespace StudentBundle\Services;
use Doctrine\ORM\EntityManager;

/**
 * Class PathCreator
 * @package StudentBundle\Services
 */
class PathCreator
{
    /**
     *
     * @param EntityManager $em
     *
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository("StudentBundle:Student");
        $this->studentArray = [];
    }


    /**
     * Update path based on Student's name
     */
    function updatePath()
    {
        $batchSize = 20;
        $i = 0;
        $q = $this->em->createQuery('select s from StudentBundle\Entity\Student s');
        $iterableResult = $q->iterate();
        
        foreach ($iterableResult as $row) {
            $student = $row[0];
            $path = $this->_generatePath($student->getName());
            $student->setPath($path);
            if (($i % $batchSize) === 0) {
                $this->em->flush(); // Executes all updates.
                $this->em->clear(); // Detaches all objects from Doctrine!
            }
            ++$i;
        }
        $this->em->flush();
    }

    /**
     * @param $name
     * @return string
     */
    private function _generatePath($name)
    {
        if (array_key_exists($name, $this->studentArray)){
            $this->studentArray[$name]++;
            $path = str_replace([' ', "'"], "_", strtolower($name)).'_'.$this->studentArray[$name];
        } else {
            $this->studentArray[$name] = 0;
            $path = str_replace([' ', "'"], "_", strtolower($name));
        }

        return $path;
    }
}