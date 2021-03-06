<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketStream;

/**
 * Represents the PINGREQ packet.
 */
class PingRequestPacket extends BasePacket
{
    protected static $packetType = Packet::TYPE_PINGREQ;

    public function read(PacketStream $stream)
    {
        parent::read($stream);

        $this->assertPacketFlags(0);
        $this->assertRemainingPacketLength(0);
    }
}
