<?php
namespace Modelos;
Class ClsUsuario extends ClsConexion
{
	private $id;
	private $user;
	private $password;
	private $nombre;
	private $sexo;
	private $estado;
	private $correo;
	private $foto;
	private $observacion;
	private $fecha_modificacion;
	private $fecha_creacion;
	private $nombreRol;
	private $idRol;
	private $atribRol;

	function __construct(
				$Oid = NULL,
				$Ouser = NULL,
				$Opassword = NULL,
				$Onombre = NULL,
				$Osexo = NULL,
				$Oestado = NULL,
				$Ofoto = NULL,
				$Ocorreo = NULL,
				$Oobservacion = NULL,
				$Ofecha_modificacion = NULL,
				$Ofecha_creacion = NULL
			)
			{
				$this->setId($Oid);
				$this->setUser($Ouser);
				$this->setPassword($Opassword);
				$this->setNombre($Onombre);
				$this->setSexo($Osexo);
				$this->setEstado($Oestado);
				$this->setFoto($Ofoto);
				$this->setCorreo($Ocorreo);
				$this->setObservacion($Oobservacion);
				$this->setFechaModificacion($Ofecha_modificacion);
				$this->setFechaCreacion($Ofecha_creacion);
			}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getUser() {
		return $this->user;
	}
	public function setUser($user) {
		$this->user = $user;
	}
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function getSexo() {
		return $this->sexo;
	}
	public function setSexo($sexo) {
		$this->sexo = $sexo;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function setEstado($estado) {
		$this->estado = $estado;
	}
	public function getFoto() {
		return $this->foto;
	}
	public function setFoto($foto) {
		$this->foto = $foto;
	}
	public function getCorreo() {
		return $this->correo;
	}
	public function setCorreo($correo) {
		$this->correo = $correo;
	}
	public function getObservacion() {
		return $this->observacion;
	}
	public function setObservacion($observacion) {
		$this->observacion = $observacion;
	}
	public function getFechaModificacion() {
		return $this->fecha_modificacion;
	}
	public function setFechaModificacion($fecha_modificacion) {
		$this->fecha_modificacion = $fecha_modificacion;
	}
	public function getFechaCreacion() {
		return $this->fecha_creacion;
	}
	public function setFechaCreacion($fecha_creacion) {
		$this->fecha_creacion = $fecha_creacion;
	}

}
?>
