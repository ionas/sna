<?php
/**
* Loads (the actual files) models only when needed.
*
* Notes:
* 1) HABTM
*	a) Must be setup as follows:
*	   $hasAndBelongsToMany = array(
*		   'Course' => array(
*			   'className'			 => 'Course',
*			   'joinTable'			 => 'courses_keywords',
*			   'associationForeignKey' => 'course_id'
*	   ));
*	b) Do not set 'with' unless you want the model *FILE* ALWAYS loaded when the associated table is called...
*	   I.e., if you set 'with' for Course then anytime Course is called, regardless of whether you use Keyword, the 'CoursesKeyword' table is ALWAYS loaded!
*	c) However, if you don't set 'with' then two things need be rembered:
*	   i) Cake auto-creates the associated model (but does't actually load the file)
*		  1) So you can do $this->Course->CoursesKeyword->find('all')...
*		  2) But you cannot call a custom method within the CourseKeyword model file
*			 b/c the actual file was never loaded b/c you never used 'with'
*	  ii) In order to load the file (and thus use custom methods in the CoursesKeyword model you need to bind it as such...
*		  1) $this->Course->bindModel(array('hasMany'=>array('MyCoursesProfessor'=>array('className'=>'CoursesProfessor'))));
*			 $this->Course->MyCoursesProfessor->customMethod(~);
*		  2) Note that we created the association using 'hasMany' and called the association something OTHER than 'CoursesProfessor'
*			 in this case we called the association 'MyCoursesProfessor' b/c if you call it 'CoursesProfessor' it will not load since
*			 cake has already auto-loaded the fake association earlier
*/
class LazyLoaderAppModel extends AppModel
{
	var $__backInnerAssociation = array();

	function __isset($name)
	{
		if (isset($name) && $name !== '')
		{
			$className = false;

			foreach ($this->__associations as $type)
			{
				if (isset($this->{$type}[$name]))
				{
					$className = $this->{$type}[$name]['className'];
					break;
				}
				else if ($type == 'hasAndBelongsToMany')
				{
					foreach ($this->{$type} as $associated)
					{
						if (isset($associated['with']) && $associated['with'] == $name)
						{
							$className = $name;
							break;
						}
					}
				}
			}

			if ($className !== false)
			{
				parent::__constructLinkedModel($name, $className);
				parent::__generateAssociation($type);
				return $this->{$name};
			}
		}

		return false;
	}

	function __get($name)
	{
		if (isset($this->{$name}))
		{
			return $this->{$name};
		}

		return false;
	}

	function __constructLinkedModel($assoc, $className = null)
	{
		foreach ($this->__associations as $type)
		{
			if (isset($this->{$type}[$assoc]))
			{
				return;
			}
			else if ($type == 'hasAndBelongsToMany')
			{
				foreach ($this->{$type} as $associated)
				{
					if (isset($associated['with']) && $associated['with'] == $assoc)
					{
						return;
					}
				}
			}
		}

		return parent::__constructLinkedModel($assoc, $className);
	}

	function resetAssociations()
	{
		return true;
	}
}
?>