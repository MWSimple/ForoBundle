<?php

namespace MWSimple\Bundle\ForoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MWSimple\Bundle\ForoBundle\Entity\EntradaRepository;
use MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Entrada
 *
 * @ORM\Table(name="mws_entrada")
 * @ORM\Entity(repositoryClass="MWSimple\Bundle\ForoBundle\Entity\EntradaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Entrada
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\ManyToOne(targetEntity="MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface")
     * @var FosUserSubjectInterface
     */
    private $autor;

    /**
     * @var \MWSimple\Bundle\ForoBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="MWSimple\Bundle\ForoBundle\Entity\Grupo", inversedBy="entradas", cascade={"remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupo_Id", referencedColumnName="id")
     * })
     */
    private $grupo;

    /**
     * @ORM\OneToMany(targetEntity="MWSimple\Bundle\ForoBundle\Entity\Respuesta", mappedBy="entrada", cascade={"remove"})
     */
    private $respuestas;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getTitulo();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->respuestas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Entrada
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set autor
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $autor
     * @return Entrada
     */
    public function setAutor(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $autor = null)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set grupo
     *
     * @param \MWSimple\Bundle\ForoBundle\Entity\Grupo $grupo
     * @return Entrada
     */
    public function setGrupo(\MWSimple\Bundle\ForoBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \MWSimple\Bundle\ForoBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Add respuestas
     *
     * @param \MWSimple\Bundle\ForoBundle\Entity\Respuesta $respuestas
     * @return Entrada
     */
    public function addRespuesta(\MWSimple\Bundle\ForoBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas[] = $respuestas;

        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \MWSimple\Bundle\ForoBundle\Entity\Respuesta $respuestas
     */
    public function removeRespuesta(\MWSimple\Bundle\ForoBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }
}
