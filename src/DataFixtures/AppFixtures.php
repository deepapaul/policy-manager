<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Job;
use App\Entity\Department;
use App\Entity\User;
use App\Entity\Policy;
use App\Entity\PolicyFilter;

class AppFixtures extends Fixture
{

    private $dataJobs = ['Quality Analyst', 'Web Developer'];
    private $dataDepartmentss = ['IT Quality Analysis', 'IT Web Development'];

    public function load(ObjectManager $manager)
    {
        $this->loadJob($manager);
        $this->loadDepartment($manager);
        $this->loadUsers($manager);
        $this->loadPolicies($manager);
        $this->loadPolicyFilters($manager);
    }
    public function loadJob(ObjectManager $manager)
    {
        $job = new Job();
        $job->setName('Quality Analyst');
        $this->addReference('job_qa', $job);
        $manager->persist($job);

        $job = new Job();
        $job->setName('Web Developer');
        $this->addReference('job_dev', $job);
        $manager->persist($job);
        
        $manager->flush();
    }
    public function loadDepartment(ObjectManager $manager)
    {
        $department = new Department();
        $department->setName('IT Quality Analysis');
        $this->addReference('department_qa', $department);
        $manager->persist($department);

        $department = new Department();
        $department->setName('IT Web Development');
        $this->addReference('department_dev', $department);
        $manager->persist($department);

        $manager->flush();
    }
    public function loadUsers(ObjectManager $manager)
    {
        $jobQa = $this->getReference('job_qa');
        $departmentQa = $this->getReference('department_qa');
        $user = new User();
        $user->setEmail('analyst1_quality@eqs.com');
        $user->setFirstName('Analyst 1');
        $user->setLastName('Quality');
        $user->setJob($jobQa);
        $user->setDepartment($departmentQa);
        $manager->persist($user);

        $jobDev = $this->getReference('job_dev');
        $departmentDev = $this->getReference('department_dev');
        $user = new User();
        $user->setEmail('developer1_web@eqs.com');
        $user->setFirstName('Developer 1');
        $user->setLastName('Web');
        $user->setJob($jobDev);
        $user->setDepartment($departmentDev);
        $manager->persist($user);    

        $manager->flush();
    }
    public function loadPolicies(ObjectManager $manager)
    {
        $policy = new Policy();
        $policy->setName('Policy-EQS General');
        $policy->setIsToAllUsers(true);
        $policy->setContent('!!!Content ---- Policy-EQS General----');
        $manager->persist($policy);

        $policy = new Policy();
        $policy->setName('Policy-EQS Quality Analysis');
        $policy->setIsToAllUsers(false);
        $policy->setContent('!!!Content ---- Policy-EQS Quality Analysis----');
        $this->addReference('policy_qa', $policy);
        $manager->persist($policy);

        $policy = new Policy();
        $policy->setName('Policy-EQS Web Development');
        $policy->setIsToAllUsers(false);
        $policy->setContent('!!!Content ---- Policy-Web Development----');
        $this->addReference('policy_dev', $policy);
        $manager->persist($policy);

        $manager->flush();
    }
    public function loadPolicyFilters(ObjectManager $manager)
    {
        $policyQa = $this->getReference('policy_qa');
        $policyDev = $this->getReference('policy_dev');
        $departmentQa = $this->getReference('department_qa');
        $departmentDev = $this->getReference('department_dev');
        $jobDev = $this->getReference('job_dev');

        $policyFilter = new PolicyFilter();
        $policyFilter->setPolicy($policyQa);
        $policyFilter->setDepartment($departmentQa);
        $manager->persist($policyFilter);

        $policyFilter = new PolicyFilter();
        $policyFilter->setPolicy($policyDev);
        $policyFilter->setDepartment($departmentDev);
        $policyFilter->setJob($jobDev);
        $manager->persist($policyFilter);

        $manager->flush();
    }
}
