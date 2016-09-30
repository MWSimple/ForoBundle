<?php

namespace MWSimple\Bundle\ForoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MWSimple\Bundle\ForoBundle\Entity\GrupoRepository;
use MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Grupo
 *
 * @ORM\Table(name="mws_grupo")
 * @ORM\Entity(repositoryClass="MWSimple\Bundle\ForoBundle\Entity\GrupoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Grupo
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface")
     * @ORM\JoinTable(name="mws_grupo_userfos",
     *      joinColumns={@ORM\JoinColumn(name="mws_grupo", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="fos_user", referencedColumnName="id")}
     *      )
     *
     */
    private $miembros;

    /**
     * @ORM\OneToMany(targetEntity="MWSimple\Bundle\ForoBundle\Entity\Entrada", mappedBy="grupo", cascade={"remove"})
     * @ORM\JoinTable(name="mws_entrada")
     */
    private $entradas;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface")
     * @var FosUserSubjectInterface
     */
    private $creador;

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
        return $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->miembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->editores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entrada = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add miembros
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $miembros
     * @return usuario
     */
    public function addMiembro(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $miembros)
    {
        $this->miembros[] = $miembros;

        return $this;
    }

    /**
     * Remove miembros
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $miembros
     */
    public function removeMiembro(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $miembros)
    {
        $this->miembros->removeElement($miembros);
    }

    /**
     * Get miembros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMiembros()
    {
        return $this->miembros;
    }

    /**
     * Add editores
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $editores
     * @return usuario
     */
    public function addEditor(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $editores)
    {
        $this->editores[] = $editores;

        return $this;
    }

    /**
     * Remove editores
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $editores
     */
    public function removeEditor(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $editores)
    {
        $this->editores->removeElement($editores);
    }

    /**
     * Get editores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEditores()
    {
        return $this->editores;
    }

    /**
     * Add entradas
     *
     * @param \MWSimple\Bundle\ForoBundle\Entity\Entrada $entradas
     * @return entrada
     */
    public function addEntradas(\MWSimple\Bundle\ForoBundle\Entity\Entrada $entradas)
    {
        $this->entradas[] = $entradas;

        return $this;
    }

    /**
     * Remove entradas
     *
     * @param \MWSimple\Bundle\ForoBundle\Entity\Entrada $entradas
     */
    public function removeEntradas(\MWSimple\Bundle\ForoBundle\Entity\Entrada $entradas)
    {
        $this->entradas->removeElement($entradas);
    }

    /**
     * Get entradas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntradas()
    {
        return $this->entradas;
    }

    /**
     * Set creador
     *
     * @param \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $creador
     * @return Respuesta
     */
    public function setCreador(\MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface $creador = null)
    {
        $this->creador = $creador;

        return $this;
    }

    /**
     * Get creador
     *
     * @return \MWSimple\Bundle\ForoBundle\Model\FosUserSubjectInterface 
     */
    public function getCreador()
    {
        return $this->creador;
    }
}
