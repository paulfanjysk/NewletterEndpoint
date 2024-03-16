<?php
namespace JYSK\NewsletterEndpoint\Model;

use JYSK\NewsletterEndpoint\Api\SubscriptionInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Subscription implements SubscriptionInterface
{
    protected $subscriberFactory;
    protected $customer;
    protected $storemanager;

    public function __construct(
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        \Magento\Customer\Model\CustomerFactory $customer,
        \Magento\Store\Model\StoreManagerInterface $storemanager
    ) {
        $this->subscriberFactory = $subscriberFactory;
        $this->customer = $customer;
        $this->storemanager = $storemanager;
    }

    /**
     * Returns user email
     * @param string $email
     * @return void
     */
    public function subscribeByEmail($email)
    {
        $websiteId = $this->storemanager->getStore()->getWebsiteId();
        $customerId = $this->customer->create()->setWebsiteId($websiteId)->loadByEmail($email)->getId();
        if ($customerId) {
            $this->subscriberFactory->create()->subscribeCustomerById($customerId);
        } else {
            $this->subscriberFactory->create()->subscribe($email);
        }
    }

    /**
     * @param string $email
     * @return string
     */
    public function isSubscribed($email)
    {
        $subscriber = $this->subscriberFactory->create()->loadByEmail($email);
        if ($subscriber->getId()) {
            if ($subscriber->isSubscribed()) {
                return "Email found. Subscription status: Subscribed";
            } else {
                return "Email found. Subscription status: Not Subscribed";
            }
        } else {
            throw new NoSuchEntityException(__('Email not found'));
        }
    }

    /**
     * @param string $email
     * @return void
     */
    public function deleteByEmail($email)
    {
        $websiteId = $this->storemanager->getStore()->getWebsiteId();
        $customerId = $this->customer->create()->setWebsiteId($websiteId)->loadByEmail($email)->getId();

        // Check if the email belongs to a customer
        if ($customerId) {
            $this->subscriberFactory->create()->unsubscribeCustomerById($customerId, true); // Disable email sending
            return; // Unsubscribed successfully
        }

        // Check if the email exists in the newsletter subscriber table
        $subscriber = $this->subscriberFactory->create()->loadByEmail($email);
        if ($subscriber->getId()) {
        // If the email exists in the newsletter subscriber table, unsubscribe the subscriber
        // Disable email sending by setting the subscriber into "import mode"
        $subscriber->setImportMode(true);
        $subscriber->unsubscribe();
        $subscriber->save();

          return; // Unsubscribed successfully
        }

        // If email is neither a customer nor a newsletter subscriber, do nothing
    }
}
