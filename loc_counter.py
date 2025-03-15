import os

def count_lines_of_code(directory, extensions):
    total_lines = 0
    file_counts = {}
    
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith(extensions):
                file_path = os.path.join(root, file)
                try:
                    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
                        lines = f.readlines()
                        non_empty_lines = [line for line in lines if line.strip()]
                        line_count = len(non_empty_lines)
                        total_lines += line_count
                        file_counts[file_path] = line_count
                except Exception as e:
                    print(f"Error reading {file_path}: {e}")
    
    return total_lines, file_counts

if __name__ == "__main__":
    project_directory = input("Enter the project directory path: ")
    extensions = (".css", ".js", ".php", ".html")
    total, details = count_lines_of_code(project_directory, extensions)
    
    print("\nLines of Code (LOC) per file:")
    for file, count in details.items():
        print(f"{file}: {count} lines")
    
    print(f"\nTotal Lines of Code: {total}")
