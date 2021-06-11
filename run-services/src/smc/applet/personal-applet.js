const {
  CommandApdu
} = require('smartcard');
const legacy = require('legacy-encoding');
// const dayjs = require('dayjs');
const reader = require('../../helper/reader');
const {
  apduPerson
} = require('../apdu');
const hex2imagebase64 = require('hex2imagebase64');

class PersonalApplet {
  constructor(card, req = [0x00, 0xc0, 0x00, 0x00]) {
    this.card = card;
    this.req = req;
  }

  async getInfo(query = ['cid']) {
    // check card
    await this.card.issueCommand(
      new CommandApdu(
        new CommandApdu({
          bytes: [...apduPerson.SELECT, ...apduPerson.THAI_CARD],
        })
      )
    );

    const q = query.reduce((q, key) => ({
      ...q,
      [key]: true
    }), {
      'cid': false,
      'name': false
    });

    const info = {};
    let data;
    // cid
    if (q.cid) {
      data = await reader.getData(this.card, apduPerson.CMD_CID, this.req);
      info.cid = data.slice(0, -2).toString();
    }

    // TH fullname
    if (q.name) {
      data = await reader.getData(this.card, apduPerson.CMD_THFULLNAME, this.req);
      data = legacy.decode(data, 'tis620');
      data = data
        .slice(0, -2)
        .toString()
        .trim()
        .split('#'); // prefix, firstname, lastname
      const th = {
        prefix: data[0],
        firstname: data[1],
        middlename: data[2],
        lastname: data[3],
        fullname: data.reduce((name, d) => {
          if (d.length === 0) {
            return name;
          }
          return `${name} ${d}`;
        }, '').trim().replace(' ', ''),
      };

      info.name = th;
    }
    return info;
  }
}

module.exports = PersonalApplet;