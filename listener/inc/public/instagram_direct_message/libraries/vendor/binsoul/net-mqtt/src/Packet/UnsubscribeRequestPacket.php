<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the UNSUBSCRIBE packet.
 */
class UnsubscribeRequestPacket extends BasePacket
{
    use IdentifiablePacket;

    /** @var string */
    private $topic;

    protected static $packetType = Packet::TYPE_UNSUBSCRIBE;
    protected $packetFlags = 2;

    public function read(PacketStream $stream)
    {
        parent::read($stream);

        $this->assertPacketFlags(2);
        $this->assertRemainingPacketLength();

        $originalPosition = $stream->getPosition();

        do {
            $this->identifier = $stream->readWord();
            $this->topic = $stream->readString();
        } while (($stream->getPosition() - $originalPosition) <= $this->remainingPacketLength);
    }

    public function write(PacketStream $stream)
    {
        $data = new PacketStream();

        $data->writeWord($this->generateIdentifier());
        $data->writeString($this->topic);

        $this->remainingPacketLength = $data->length();

        parent::write($stream);
        $stream->write($data->getData());
    }

    /**
     * Returns the topic.
     *
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * Sets the topic.
     *
     * @param string $value
     *
     * @return void
     */
    public function setTopic(string $value)
    {
        $this->topic = $value;
    }
}
