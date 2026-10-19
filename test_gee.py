import sys
import traceback

sys.path.append('scripts/gee_service')
try:
    from main import get_mapbiomas_tile_url
    url = get_mapbiomas_tile_url(2022)
    print("SUCCESS:", url)
except Exception as e:
    print("ERROR TRACEBACK:")
    traceback.print_exc()
