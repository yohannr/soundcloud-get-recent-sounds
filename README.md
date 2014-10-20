# Soundcloud-get-recent-sounds

Example of using Soundcloud API.
Goal : get recent sounds of artists, within favorites of a user.
Regarding the Soundcloud stream, it doesn't care about the playlist, just care about new sounds (within one week)

## TODO

- first step : reduce time of process
- second step : format results in a table
- third step : run as CRON script and send mail every week/day with these new sounds
- next step : select major artists to follow

## Notes

- refer to API console : https://developers.soundcloud.com/console
- index of the API guide : https://developers.soundcloud.com/docs/api/guide
- use config file and declare CLIENT_ID and USER_ID (can be found by using http://api.soundcloud.com/resolve.json?url=http://soundcloud.com/YOUR_USER_NAME&client_id=YOUR_CLIENT_ID)