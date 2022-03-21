import { TeamSpeak, QueryProtocol,TeamSpeakServerGroup,TeamSpeakClient,TeamSpeakServer} from "ts3-nodejs-library"
const mysql = require('mysql')

const channelID = ["2", "3"];              // Modify Channels here
const groupID = ["9", "10", "11", "12"];    //Modify Groups here

const NonRegistred = "13";
const NonRegistredChannel = 1;

let moderatorArray: any[] = [{"uid":"","min":0,"joined":"","leaved":""}];
// Database Connection

const host = "localhost";
const db = "moderators";
const user = "root";
const pass = "";
const acquireTimeout = 1000000;

const connectionString = {host: host, user: user, password: pass, database: db, acquireTimeout:acquireTimeout}
const connection = mysql.createConnection(connectionString)

process.on('uncaughtException', error => {
    setTimeout(() => {

        if (error.message == "read ECONNRESET") {
            console.log("\x1b[33m [MySQL] Connection timeout but it will reconnect when it get a query")
        } else {

            console.log(`\x1b[31m [BOT] Critical error: ${error}`)
            for (let i = 0; i < moderatorArray.length; i++) {
                let d = new Date;
                saveDutyMin(moderatorArray[i].uid,moderatorArray[i].min,moderatorArray[i].joined,d)
                moderatorArray.splice(i, 1);
            }
        }
    }, 100)
})


// TeamSpeak connection + Events

const teamspeak = new TeamSpeak({
    host: "localhost",
    protocol: QueryProtocol.RAW, //optional
    queryport: 10011, //optional
    serverport: 9987,
    username: "serveradmin",
    password: "Pzj9L7yY",
    nickname: "Moderation Agency",
    readyTimeout: 2147483647,
    keepAlive: true,
    ignoreQueries: true,
    autoConnect: true,
    keepAliveTimeout: 10
})

function addToModeratorArray(cl:TeamSpeakClient) {
    let ui = cl.uniqueIdentifier
    let exist = false;
    let clientGroups = cl.servergroups;
    for (let i = 0; i < clientGroups.length; i++) {
        if (groupID.includes(clientGroups[i])) {
            for (let j = 0; j < moderatorArray.length; j++) {
                if (moderatorArray[j].uid.includes(cl.uniqueIdentifier)){
                    exist = true;
                    break;
                }
            }
            if (!exist) {
                let d = new Date;
                moderatorArray.push({"uid":ui,"min":0,"joined":d,"leaved":""});
            }
        }
    }
}

function removeModeratorArray(disconnectedClient:TeamSpeakClient) {
    for (let i = 0; i < moderatorArray.length; i++) {
        if (moderatorArray[i].uid.includes(disconnectedClient.uniqueIdentifier)) {

            let d = new Date;
            // @ts-ignore
            saveDutyMin(moderatorArray[i].uid,moderatorArray[i].min,moderatorArray[i].joined,d)
            moderatorArray.splice(i, 1);
            break;
        }
    }
}

teamspeak.connect().then( async teamspeak => {


    let clients = await teamspeak.clientList();
    for (let i = 0; i < clients.length; i++) {
        let client = clients[i];
        addToModeratorArray(client);
    }

    teamspeak.on("clientconnect",event => {
        if (event.client.servergroups.includes(NonRegistred) && NonRegistredChannel == (event.client.channelGroupInheritedChannelId)) {
            alertMod(teamspeak,event.client)
        }
            addToModeratorArray(event.client)
            getSeen(teamspeak,event.client)
    })

    teamspeak.on("clientdisconnect",event => {
        // @ts-ignore
        removeModeratorArray(event.client);
    })

    teamspeak.on("close", async () => {
        console.log("\x1b[31m [BOT] Disconnected, trying to reconnect...")
        await teamspeak.reconnect(-1, 1000)
        console.log("\x1b[32m [BOT] Reconnected!")
    })

    teamspeak.on("error", (event) => {
        console.log("\x1b[31m [BOT] Had an error, trying to reconnect...")
        console.log("\x1b[31m "+event.message);
        teamspeak.reconnect(-1, 1000)
        console.log("\x1b[32m [BOT] Reconnected!")
    })

    setInterval(counter, 60000);

    console.log("\x1b[32m [BOT] Connection Event Active")
    connectToDatabase()
    getModerators()
    console.log("\x1b[32m [BOT] Started Successfully!")
}).catch(e => {
    console.log("\x1b[31m [BOT] Catched an error!")
    console.error(e)
})

function connectToDatabase() {
    connection.connect()

// @ts-ignore
    connection.query('SELECT 1 + 1 AS solution', function (err, rows, fields) {
        if (err) {
            console.log("\x1b[31m [MySQL] Error!")
            throw err
        }
        console.log('\x1b[32m [MySQL] Connected Successfully')
    })
}

async function getModerators() {
    console.log("\x1b[32m [BOT] Upload/Modify all moderators into database")
    const serverGroups = await teamspeak.serverGroupList()

    for (const serverGroupsKey in serverGroups) {
        if (groupID.includes(await TeamSpeakServerGroup.getId(serverGroupsKey))) {
            let clientList = await teamspeak.serverGroupClientList(serverGroupsKey)
            let TsGroup = await teamspeak.getServerGroupById(serverGroupsKey)
            for (let i = 0; i < clientList.length; i++) {
                let name = clientList[i].clientNickname
                let ui = clientList[i].clientUniqueIdentifier

                let client = await teamspeak.getClientByName(name);
                // @ts-ignore
                let gname = TsGroup.name;
                // @ts-ignore
                connection.query('SELECT `uID` from members WHERE uID = \"'+ui+'"', function (err, rows, fields) {
                    if (err) throw err
                    if (rows.length == 0) {
                        //@ts-ignore
                        connection.query('INSERT INTO `members`(`ID`, `name`, `uID`, `rank`) VALUES (NULL,\"' + name + '","' + ui + '","' + gname + '")', function (err, rows, fields) {
                            if (err) throw err
                        })
                    }})
            }
        }
    }
}

async function counter() {
    const channels = await teamspeak.channelList();
    let thisClient = false;

    for (const channel of channels) {
        if (channelID.includes(channel.cid)) {
            const clients = await channel.getClients({clientType: 0});
            for (let i = 0; i < clients.length; i++) {
                let client = clients[i];
                for (let j = 0; j < moderatorArray.length; j++) {
                    if (moderatorArray[j].uid.includes(client.uniqueIdentifier)) {
                        if (client.inputMuted == false && client.outputMuted == false)
                        {
                            moderatorArray[j].min += 1;
                            break;
                        }
                    }
                }
            }
        }
    }
}

async function alertMod(ts: TeamSpeak,cl:TeamSpeakClient) {
    const channels = await ts.channelList();
    for (const channel of channels) {
        if (channelID.includes(channel.cid)) {
            const clients = await channel.getClients({clientType: 0});
            for (let i = 0; i < clients.length; i++) {
                let client = clients[i];
                for (let j = 0; j < client.servergroups.length; j++) {
                    if (groupID.includes(client.servergroups[j])) {
                        let identity = "[URL=client://" + cl.clid + "/" + cl.uniqueIdentifier + "]" + cl.nickname + "[/URL]"
                        client.message("Új nem regisztrált a betoppanóban! ( " + identity + " )");
                        await client.poke("Új nem regisztrált a betoppanóban! ( " + cl.nickname + " )");
                    }
                }
            }
        }
    }
}

async function getSeen(ts: TeamSpeak,cl:TeamSpeakClient) {
    getModerators();
    let clientGroups = cl.servergroups;
    for (let i = 0; i < clientGroups.length; i++) {
        if (groupID.includes(clientGroups[i])) {
            let date = new Date().toISOString().slice(0, 10)
            // @ts-ignore
            connection.query('UPDATE `members` SET `lastSeen` = \"'+date+'" WHERE uID = \"'+cl.uniqueIdentifier+'"' , function (err, rows, fields) {
                if (err) throw err
            })
            // @ts-ignore
            connection.query('UPDATE `members` SET `connection` = connection+1 WHERE uID = \"'+cl.uniqueIdentifier+'"' , function (err, rows, fields) {
                if (err) throw err
            })
            break;
        }
    }
}

// @ts-ignore
async function saveDutyMin(uID,min,joined,leaved)
{
    let difference = Math.round((leaved.getTime()-joined.getTime())/(1000 * 60));

    let date = new Date().toISOString().slice(0, 10)

    // @ts-ignore
    connection.query('SELECT `uID` from dutyTime WHERE uID = \"'+uID+'" AND date = "'+date+'"', function (err, rows, fields) {
        if (err) throw err
        if (rows.length == 0) {
            //@ts-ignore
            connection.query('INSERT INTO `dutytime` (`uID`, `min`,`activetime`,`date`) VALUES (\"' + uID + '",' + min + ',"'+difference+'","' + date + '")', function (err, rows, fields) {
                if (err) throw err
            })
        } else {
            //@ts-ignore
            connection.query('UPDATE `dutytime` SET activetime = activetime +'+difference+', min = min+\"'+min+'" WHERE uID = \"'+uID+'" AND date = \"'+date+'"', function (err, rows, fields) {
                if (err) throw err
            })
        }})

            //@ts-ignore
            connection.query('INSERT INTO `log`(`ID`, `uID`, `joined`,`leaved`) VALUES (NULL, \"' + uID + '","' + joined.toLocaleString()  + '","'+leaved.toLocaleString()+'")', function (err, rows, fields) {
                if (err) throw err
            })
}

process.on('exit', (code) => {
        console.log("\x1b[32m [BOT] Stopping services")
        let d = new Date;
        for (let i = 0; i < moderatorArray.length; i++) {
            saveDutyMin(moderatorArray[i].uid,moderatorArray[i].min,moderatorArray[i].joined,d)
        }
        console.log("\x1b[32m [BOT] Successfully saved all data...")
        console.log("\x1b[32m [BOT] Exiting...")
        process.exit();
});
