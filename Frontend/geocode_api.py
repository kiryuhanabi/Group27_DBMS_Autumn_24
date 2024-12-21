from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

def get_lat_lon(location_name):
    url = f"https://nominatim.openstreetmap.org/search?q={location_name}&format=json"
    response = requests.get(url)
    if response.status_code == 200:
        data = response.json()
        if data:
            lat = data[0]['lat']
            lon = data[0]['lon']
            return {"latitude": lat, "longitude": lon}
    return None

@app.route('/geocode', methods=['GET'])
def geocode():
    location_name = request.args.get('location')
    if location_name:
        coordinates = get_lat_lon(location_name)
        if coordinates:
            return jsonify(coordinates)
    return jsonify({"error": "Location not found"}), 404

if __name__ == '__main__':
    app.run(debug=True)
