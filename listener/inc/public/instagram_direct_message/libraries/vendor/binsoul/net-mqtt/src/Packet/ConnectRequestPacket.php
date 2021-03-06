<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Exception\MalformedPacketException;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the CONNECT packet.
 */
class ConnectRequestPacket extends BasePacket
{
    /** @var int */
    private $protocolLevel = 4;
    /** @var string */
    private $protocolName = 'MQTT';
    /** @var int */
    private $flags = 2;
    /** @var string */
    protected $clientID = '';
    /** @var int */
    private $keepAlive = 60;
    /** @var string */
    private $willTopic = '';
    /** @var string */
    private $willMessage = '';
    /** @var string */
    private $username = '';
    /** @var string */
    private $password = '';

    protected static $packetType = Packet::TYPE_CONNECT;

    public function read(PacketStream $stream)
    {
        parent::read($stream);
        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength();

        $this->protocolName = $stream->readString();
        $this->protocolLevel = $stream->readByte();
        $this->flags = $stream->readByte();
        $this->keepAlive = $stream->readWord();
        $this->clientID = $stream->readString();

        if ($this->hasWill()) {
            $this->willTopic = $stream->readString();
            $this->willMessage = $stream->readString();
        }

        if ($this->hasUsername()) {
            $this->username = $stream->readString();
        }

        if ($this->hasPassword()) {
            $this->password = $stream->readString();
        }

        $this->assertValidWill();
        $this->assertValidString($this->clientID);
        $this->assertValidString($this->willTopic);
        $this->assertValidString($this->username);
    }

    public function write(PacketStream $stream)
    {
        if ($this->clientID === '') {
            try {
                $this->clientID = 'BinSoul'.random_int(100000, 999999);
            } catch (\Exception $e) {
                $this->clientID = 'BinSoul'.mt_rand(100000, 999999);
            }
        }

        $data = new PacketStream();

        $data->writeString($this->protocolName);
        $data->writeByte($this->protocolLevel);
        $data->writeByte($this->flags);
        $data->writeWord($this->keepAlive);
        $data->writeString($this->clientID);

        if ($this->hasWill()) {
            $data->writeString($this->willTopic);
            $data->writeString($this->willMessage);
        }

        if ($this->hasUsername()) {
            $data->writeString($this->username);
        }

        if ($this->hasPassword()) {
            $data->writeString($this->password);
        }

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Returns the protocol level.
     *
     * @return int
     */
    public function getProtocolLevel(): int
    {
        return $this->protocolLevel;
    }

    /**
     * Sets the protocol level.
     *
     * @param int $value
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setProtocolLevel(int $value)
    {
        if ($value < 3 || $value > 4) {
            throw new \InvalidArgumentException(sprintf('Unknown protocol level %d.', $value));
        }

        $this->protocolLevel = $value;
        if ($this->protocolLevel === 3) {
            $this->protocolName = 'MQIsdp';
        } elseif ($this->protocolLevel === 4) {
            $this->protocolName = 'MQTT';
        }
    }

    /**
     * Returns the client id.
     *
     * @return string
     */
    public function getClientID(): string
    {
        return $this->clientID;
    }

    /**
     * Sets the client id.
     *
     * @param string $value
     *
     * @return void
     */
    public function setClientID(string $value)
    {
        $this->clientID = $value;
    }

    /**
     * Returns the keep alive time in seconds.
     *
     * @return int
     */
    public function getKeepAlive(): int
    {
        return $this->keepAlive;
    }

    /**
     * Sets the keep alive time in seconds.
     *
     * @param int $value
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setKeepAlive(int $value)
    {
        if ($value > 65535) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected a keep alive time lower than 65535 but got %d.',
                    $value
                )
            );
        }

        $this->keepAlive = $value;
    }

    /**
     * Indicates if the clean session flag is set.
     *
     * @return bool
     */
    public function isCleanSession(): bool
    {
        return ($this->flags & 2) === 2;
    }

    /**
     * Changes the clean session flag.
     *
     * @param bool $value
     *
     * @return void
     */
    public function setCleanSession(bool $value)
    {
        if ($value) {
            $this->flags |= 2;
        } else {
            $this->flags &= ~2;
        }
    }

    /**
     * Indicates if a will is set.
     *
     * @return bool
     */
    public function hasWill(): bool
    {
        return ($this->flags & 4) === 4;
    }

    /**
     * Returns the desired quality of service level of the will.
     *
     * @return int
     */
    public function getWillQosLevel(): int
    {
        return ($this->flags & 24) >> 3;
    }

    /**
     * Indicates if the will should be retained.
     *
     * @return bool
     */
    public function isWillRetained(): bool
    {
        return ($this->flags & 32) === 32;
    }

    /**
     * Returns the will topic.
     *
     * @return string
     */
    public function getWillTopic(): string
    {
        return $this->willTopic;
    }

    /**
     * Returns the will message.
     *
     * @return string
     */
    public function getWillMessage(): string
    {
        return $this->willMessage;
    }

    /**
     * Sets the will.
     *
     * @param string $topic
     * @param string $message
     * @param int    $qosLevel
     * @param bool   $isRetained
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setWill(string $topic, string $message, int $qosLevel = 0, bool $isRetained = false)
    {
        $this->assertValidString($topic, false);
        if ($topic === '') {
            throw new \InvalidArgumentException('The topic must not be empty.');
        }

        $this->assertValidStringLength($message, false);
        if ($message === '') {
            throw new \InvalidArgumentException('The message must not be empty.');
        }

        $this->assertValidQosLevel($qosLevel, false);

        $this->willTopic = $topic;
        $this->willMessage = $message;

        $this->flags |= 4;
        $this->flags |= ($qosLevel << 3);

        if ($isRetained) {
            $this->flags |= 32;
        } else {
            $this->flags &= ~32;
        }
    }

    /**
     * Removes the will.
     *
     * @return void
     */
    public function removeWill()
    {
        $this->flags &= ~60;
        $this->willTopic = '';
        $this->willMessage = '';
    }

    /**
     * Indicates if a username is set.
     *
     * @return bool
     */
    public function hasUsername(): bool
    {
        return (bool) ($this->flags & 64);
    }

    /**
     * Returns the username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Sets the username.
     *
     * @param string $value
     *
     * @return void
     */
    public function setUsername(string $value)
    {
        $this->assertValidString($value, false);

        $this->username = $value;
        if ($this->username !== '') {
            $this->flags |= 64;
        } else {
            $this->flags &= ~64;
        }
    }

    /**
     * Indicates if a password is set.
     *
     * @return bool
     */
    public function hasPassword(): bool
    {
        return (bool) ($this->flags & 128);
    }

    /**
     * Returns the password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Sets the password.
     *
     * @param string $value
     *
     * @return void
     */
    public function setPassword(string $value)
    {
        $this->assertValidStringLength($value, false);

        $this->password = $value;
        if ($this->password !== '') {
            $this->flags |= 128;
        } else {
            $this->flags &= ~128;
        }
    }

    /**
     * Asserts that all will flags and quality of service are correct.
     *
     * @return void
     *
     * @throws MalformedPacketException
     */
    private function assertValidWill()
    {
        if ($this->hasWill()) {
            $this->assertValidQosLevel($this->getWillQosLevel(), true);
        } else {
            if ($this->getWillQosLevel() > 0) {
                $this->throwException(
                    sprintf(
                        'Expected a will quality of service level of zero but got %d.',
                        $this->getWillQosLevel()
                    ),
                    true
                );
            }

            if ($this->isWillRetained()) {
                $this->throwException('There is not will but the will retain flag is set.', true);
            }
        }
    }
}
